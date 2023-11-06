<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Booking;
use Filament\Notifications\Notification;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeEdit(): void
    {
        $data = $this->data;

        if (Booking::isBookingExists($data['facility_id'], $data['date'], $data['start_time'], $data['end_time'])->exists()) {
            Notification::make()
                ->warning()
                ->title('Your choosen date or time is already booked')
                ->body('Please choose another date or time')
                ->send();

            $this->halt();
        }
    }
    
}
