<?php

namespace App\Filament\Resources\VisitorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use App\Models\VisitorLog;

class VisitorLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'visitorLogs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('unit_id')
                    ->required()
                    ->searchable()
                    ->relationship(name: 'unit', titleAttribute: 'name'),
                Forms\Components\TextInput::make('purpose')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('purpose')
            ->columns([
                Tables\Columns\TextColumn::make('purpose'),
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unit'),
                Tables\Columns\TextColumn::make('arrival_time'),
                Tables\Columns\TextColumn::make('departure_time'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {

                        $data['visit_date'] = now()->format('Y-m-d');
                        $data ['arrival_time'] = now()->format('H:i:s');
                        $data['status'] = 'checked_in';

                        return $data;
                    }),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
