<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Get;
use Illuminate\Support\Arr;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\BookingResource\Widgets;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Resident';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('facility_id')
                        ->relationship('facility', 'name')->required(),
                        Forms\Components\DatePicker::make('date')->required(),
                        Forms\Components\Select::make('start_time')
                        ->options(self::openHours())->required()->rules(['date_format:H:i:s'])->before('end_time'),
                        Forms\Components\Select::make('end_time')
                        ->options(self::openHours())->required()->rules(['required','date_format:H:i:s'])->after('start_time'),
                ])->columns(2)
            ]);
    }

    private static function openHours()
    {
        $startPeriod = Carbon::parse('10:00');
        $endPeriod   = Carbon::parse('22:00');

        $period = CarbonPeriod::create($startPeriod, '1 hour', $endPeriod);

        $hours  = [];
        foreach ($period as $date) {
            $hours[] = $date->format('H:i:s');
        }

        $combineHours = array_combine($hours, $hours);

        return $combineHours;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Booking $booking) => $booking->status == 'canceled' ? false : route('filament.admin.resources.bookings.edit', ['record' => $booking->id]))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facility.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'booked' => 'success',
                        'canceled' => 'danger',
                        'completed' => 'info',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->disabled(fn (Booking $booking) => $booking->status == 'canceled'),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('cancel')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-m-archive-box-x-mark')
                    ->disabled(fn (Booking $booking) => $booking->status == 'canceled')
                    ->action(function (Booking $booking): void {
                        $booking->status = 'canceled';
                        $booking->update();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('cancel')
                    ->icon('heroicon-m-archive-box-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Collection $bookings): void {
                        foreach ($bookings as $booking) {
                            $booking->status = 'canceled';
                            $booking->update();
                        }
                    }),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Booking $booking): bool => $booking->status !== 'canceled',
            )
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(Auth::user()->hasRole('resident')) {
            return parent::getEloquentQuery()->where('user_id', Auth::user()->id);
        } else {
            return parent::getEloquentQuery();
        }
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\BookingOverview::class,
        ];
    }
}
