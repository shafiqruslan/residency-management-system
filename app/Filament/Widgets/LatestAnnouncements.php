<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AnnouncementResource;
use App\Models\Announcement;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAnnouncements extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(5)
            ->query(
                AnnouncementResource::getEloquentQuery()
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date()
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Announcement $record): string => AnnouncementResource::getUrl('view', ['record' => $record])),
            ]);
    }

}
