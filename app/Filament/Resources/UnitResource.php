<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UnitResource\Widgets;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Setup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('size')
                        ->required(),
                    Forms\Components\Select::make('type')
                        ->options([
                            '1' => 'Studio',
                            '2' => 'Condo',
                            '3' => 'Penthouse',
                            '4' => 'Duplex',
                        ])->required(),
                    Forms\Components\Radio::make('status')->options([
                        'occupied' => 'Occupied',
                        'available' => 'Available',
                    ])->required(),
                    // Forms\Components\Select::make('parkings')
                    //     ->relationship(
                    //         name:'parkings',
                    //         titleAttribute: 'name',
                    //         modifyQueryUsing: fn (Builder $query) => $query->where('status', 'available'),
                    //     )
                    //     ->multiple()
                    //     ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        1 => 'Studio',
                        2 => 'Condo',
                        3 => 'Penthouse',
                        4 => 'duplex',
                        default => 'Unknown',
                    })
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'occupied' => 'success',
                        'available' => 'danger',
                    })
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ResidentsRelationManager::class,
            RelationManagers\ParkingUnitsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\UnitOverview::class,
        ];
    }
}
