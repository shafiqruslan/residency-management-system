<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use App\Models\Unit;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
        $data = $this->data;

        $units = $data['units'];
        $title = $data['title'];

        foreach ($units as $unit) {
            $query_unit = Unit::find($unit);
            foreach ($query_unit->residents as $resident) {
                Notification::make()
                ->title($title)
                ->icon('heroicon-o-bell-alert')
                ->actions([
                    Action::make('View')
                        ->url(AnnouncementResource::getUrl('view', ['record' => $this->record->id])),
                ])
                ->sendToDatabase($resident->user);
            }
        }

    }
}
