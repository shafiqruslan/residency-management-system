<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParkingUnitResource\Pages;
use App\Filament\Resources\ParkingUnitResource\RelationManagers;
use App\Models\ParkingUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ParkingUnitResource extends Resource
{
    protected static ?string $model = ParkingUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Resident';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Select::make('parking_id')
                                        ->required()
                                        ->searchable()
                                        ->relationship(
                                            name:'parking',
                                            titleAttribute: 'name',
                                            modifyQueryUsing: fn (Builder $query) => $query->where('type', 'reserved')->where('status', 'available'),
                                        ),
                                    // Forms\Components\Select::make('unit_id')
                                    //     ->required(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('staff'))
                                    //     ->hidden(Auth::user()->hasRole('resident'))
                                    //     ->searchable()
                                    //     ->relationship(
                                    //         name:'unit',
                                    //         titleAttribute: 'name',
                                    //     ),
                                ])->columns(2),
                            Forms\Components\Section::make('Vehicle')
                                ->relationship('vehicle')
                                ->schema([
                                    Forms\Components\TextInput::make('plate_number')
                                    ->required(),
                                    Forms\Components\TextInput::make('model')
                                        ->required(),
                                    Forms\Components\TextInput::make('color')
                                        ->required(),
                                    Forms\Components\DatePicker::make('registration_date')
                                        ->required()
                                ])->columns(2),
                        ])->columnSpan(['lg' => fn (?ParkingUnit $record) => $record === null ? 3 : 2]),

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Placeholder::make('created_at')
                                        ->content(fn (ParkingUnit $record): string => $record->created_at->toFormattedDateString()),
                                    Forms\Components\Placeholder::make('updated_at')
                                        ->content(fn (ParkingUnit $record): string => $record->updated_at->diffForHumans(now()))
                                ]),
                        ])->columnSpan(['lg' => 1])
                        ->hidden(fn (?ParkingUnit $record) => $record === null),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parking.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parking.type')
                    ->label('Type')
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('xl'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParkingUnit::route('/'),
            'create' => Pages\CreateParkingUnit::route('/create'),
            'edit' => Pages\EditParkingUnit::route('/{record}/edit'),
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
