<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParkingResource\Pages;
use App\Filament\Resources\ParkingResource\RelationManagers;
use App\Models\Parking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ParkingResource\Widgets;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParkingResource extends Resource
{
    protected static ?string $model = Parking::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'Setup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'resident' => 'Resident',
                        'visitor' => 'Visitor',
                        'reserved' => 'Reserved',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
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
                Tables\Actions\EditAction::make()
                    ->modalWidth('xl'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageParkings::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\ParkingOverview::class,
        ];
    }
}
