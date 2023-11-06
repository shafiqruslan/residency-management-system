<?php

namespace App\Filament\Resources\ParkingUnitResource\Pages;

use App\Filament\Resources\ParkingUnitResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\Parking;

class CreateParkingUnit extends CreateRecord
{
    protected static string $resource = ParkingUnitResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['unit_id'] = Auth::user()->resident->unit_id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $data = $this->data;

        Parking::find($data['parking_id'])->update([
            'status' => 'occupied'
        ]);
    }

}
