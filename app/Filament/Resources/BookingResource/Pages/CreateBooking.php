<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Facility;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;
use App\Models\Booking;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $pricePerHour = Facility::find($data['facility_id'])->price_per_hour;

        $data['user_id'] = Auth::user()->id;
        $data['total_price'] = $this->calculateDiffHours($data['start_time'], $data['end_time']) * $pricePerHour;
        $data['status'] = 'booked';

        return $data;
    }

    protected function beforeCreate(): void
    {
        $data = $this->data;

        if (Booking::isBooked($data['facility_id'], $data['date'], $data['start_time'], $data['end_time'])->exists()) {
            Notification::make()
                ->warning()
                ->title('Your choosen date or time is already booked')
                ->body('Please choose another date or time')
                ->send();

            $this->halt();
        }
    }

    private function calculateDiffHours($startTime, $endTime)
    {
        $startTimestamp = Carbon::parse($startTime);
        $endTimestamp = Carbon::parse($endTime);

        $bookingDurationHours = $endTimestamp->diffInHours($startTimestamp);

        return $bookingDurationHours;
    }
}
