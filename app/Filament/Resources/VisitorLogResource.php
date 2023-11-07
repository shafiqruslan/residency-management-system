<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorLogResource\Pages;
use App\Filament\Resources\VisitorLogResource\RelationManagers;
use App\Models\VisitorLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitorLogResource extends Resource
{
    protected static ?string $model = VisitorLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-on-rectangle';

    protected static ?string $navigationGroup = 'Visitor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('visitor_id')
                    ->required()
                    ->searchable()
                    ->relationship(name: 'visitor', titleAttribute: 'name'),
                Forms\Components\Select::make('unit_id')
                    ->required()
                    ->searchable()
                    ->relationship(name: 'unit', titleAttribute: 'name'),
                Forms\Components\Textarea::make('purpose')
                    ->rows(3)
                    ->required()
                ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->columns([
                Tables\Columns\TextColumn::make('visitor.name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visitor.identification_number')
                    ->label('Identification Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('arrival_time')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('departure_time')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Checked Out')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-m-archive-box-x-mark')
                    ->hidden(fn (VisitorLog $visitorLog) => $visitorLog->status == 'checked_out')
                    ->action(function (VisitorLog $visitorLog): void {
                        $visitorLog->departure_time = now()->format('H:i:s');
                        $visitorLog->status = 'checked_out';
                        $visitorLog->update();
                    }),
                ]);
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
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
            'index' => Pages\ListVisitorLogs::route('/'),
            'create' => Pages\CreateVisitorLog::route('/create'),
            'edit' => Pages\EditVisitorLog::route('/{record}/edit'),
        ];
    }
}
