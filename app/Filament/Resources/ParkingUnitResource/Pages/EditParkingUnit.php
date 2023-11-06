<?php

namespace App\Filament\Resources\ParkingUnitResource\Pages;

use App\Filament\Resources\ParkingUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParkingUnit extends EditRecord
{
    protected static string $resource = ParkingUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
