<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Unit;
use App\Models\Fee;
use LaravelDaily\Invoices\Invoice as LdInvoice;
use LaravelDaily\Invoices\Classes\Buyer as LdBuyer;
use LaravelDaily\Invoices\Classes\Party as LdParty;
use LaravelDaily\Invoices\Classes\InvoiceItem as LdInvoiceItem;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Wizard;
use App\Filament\Resources\InvoiceResource\Widgets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Resident';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Due Date')
                        ->description('Choose due date of invoice')
                        ->schema([
                            Forms\Components\DatePicker::make('due_date')
                                ->minDate(now()->startOfMonth())
                                ->maxDate(now()->endOfMonth())->columnSpan(1)
                                ->required()
                        ])->columns(2),
                    Wizard\Step::make('Fees')
                        ->description('Select fees you want to include')
                        ->schema([
                            Forms\Components\CheckboxList::make('fees')
                                ->options(
                                    Fee::all()->pluck('name', 'id')
                                )
                                ->required()
                                ->searchable()
                                ->descriptions(Fee::all()->pluck('base_amount', 'id')->mapWithKeys(function ($baseAmount, $id) {
                                    // Concatenate the sentences with the base_amount
                                    $ringgitPrice = $baseAmount / 100;

                                    if($id == 1) {
                                        $concatenatedSentence = "RM $ringgitPrice per sqft";
                                    } elseif($id == 2) {
                                        $concatenatedSentence = "RM $ringgitPrice per park";
                                    } elseif ($id == 3) {
                                        $concatenatedSentence = "RM $ringgitPrice per hourse";
                                    } else {
                                        $concatenatedSentence = "RM $ringgitPrice per amount";
                                    }
                                    return [$id => $concatenatedSentence];
                                })->all())
                            ->columnSpan(1)
                        ])->columns(2),
                    Wizard\Step::make('Units')
                        ->description('Pick unit you want to send the invoice')
                        ->schema([
                            Forms\Components\CheckboxList::make('units')
                                ->options(
                                    Unit::all()->where('status', 'occupied')->pluck('name', 'id')
                                )
                            ->required()
                            ->searchable()
                            ->columnSpan(1)
                        ])->columns(2),
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->searchable()
                    ->money('myr')
                    ->getStateUsing(function (Invoice $record): float {
                        return $record->total_amount / 100;
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                ->trueLabel('Occupied units')
                ->falseLabel('Available units')
                ->queries(
                    true: fn (Builder $query) => $query->where('status', 'occupied'),
                    false: fn (Builder $query) => $query->where('status', 'available'),
                )])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(Auth::user()->hasRole('resident')),
                Tables\Actions\Action::make('download')
                    ->link()
                    ->action(function (Invoice $invoice) {
                        $invoice->load('unit', 'invoiceItems', 'invoiceItems.fee');
                        $customer = new LdBuyer([
                            'name'          => $invoice->unit->name,
                            'address' => 'Jalan 1/2b, Taman Seri Murni, 68100, Batu Caves, Kl',
                            'phone' => '012-3456789',
                        ]);


                        $seller = new LdParty([
                            'name'          => 'Joint Management Body',
                            'address' => 'Jalan 1/2b, Taman Seri Murni, 68100, Batu Caves, Kl',
                            'phone' => '012-3456789',
                        ]);

                        $items = [];

                        foreach ($invoice->invoiceItems as $value) {
                            $items[] = (new LdInvoiceItem())->title($value->fee->name)->quantity($value->quantity)->pricePerUnit($value->fee->base_amount / 100);
                        }

                        $ldInvoice = LdInvoice::make()
                            ->buyer($customer)
                            ->seller($seller)
                            ->date(Carbon::parse($invoice->due_date))
                            ->dateFormat('d-M-Y')
                            ->payUntilDays(0)
                            ->addItems($items);

                        return response()->streamDownload(function () use ($ldInvoice) {
                            echo $ldInvoice->stream();
                        }, 'test.pdf');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->hidden(Auth::user()->hasRole('resident')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }

    public static function customAction($data)
    {
        $units = Unit::where('status', 'occupied')->get();
        $fees = Fee::get();

        foreach ($units as $unit) {
            $invoiceItem = [];

            foreach ($fees as $fee) {
                $amount = $fee->base_amount;

                if($fee->id == 1) {
                    $totalAmount = $amount * $unit->size;
                    $quantity = $unit->size;
                }

                if($fee->id == 2) {
                    $totalAmount = $amount * $unit->parkings->count();
                    $quantity = $unit->parkings->count();
                }

                $invoiceItem[] = [
                    'fee_id' => $fee->id,
                    'unit_id' => $unit->id,
                    'quantity' => $quantity,
                    'total_price' => $totalAmount,
                ];
            }

            Invoice::create([
                'number' => '001',
                'due_date' => $data['due_date'],
                'total_amount' => array_sum($totalAmount),
                'unit_id' => $unit->id,
            ])->invoice_items()->create([
                $invoiceItem
            ]);
        }
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\InvoiceOverview::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(Auth::user()->hasRole('resident')) {
            return parent::getEloquentQuery()->where('unit_id', Auth::user()->resident->unit->id ?? 0);
        } else {
            return parent::getEloquentQuery();
        }
    }
}
