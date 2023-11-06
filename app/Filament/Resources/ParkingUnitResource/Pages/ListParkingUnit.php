<?php

namespace App\Filament\Resources\ParkingUnitResource\Pages;

use App\Filament\Resources\ParkingUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ParkingUnitResource\Widgets;
use Filament\Actions\Action;

class ListParkingUnit extends ListRecords
{
    protected static string $resource = ParkingUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\ParkingUnitOverview::class,
        ];
    }
}
