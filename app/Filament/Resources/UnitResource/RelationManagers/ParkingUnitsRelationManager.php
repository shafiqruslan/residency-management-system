<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Parking;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\AttachAction;

class ParkingUnitsRelationManager extends RelationManager
{
    protected static string $relationship = 'parkingUnits';
    protected bool $allowsDuplicates = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('parking_id')
                            ->options(Parking::all()->where('status', 'available')->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan(1),
                    ])->columns(2),
                Forms\Components\Group::make()
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
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parking.name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('parking.type')
                    ->badge()
                    ->label('Type'),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(function ($data) {
                    Parking::find($data['parking_id'])->update([
                        'status' => 'occupied'
                    ]);
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
        ;
    }
}
