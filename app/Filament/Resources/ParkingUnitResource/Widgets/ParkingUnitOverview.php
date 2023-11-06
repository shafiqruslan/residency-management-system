<?php

namespace App\Filament\Resources\ParkingUnitResource\Widgets;

use App\Filament\Resources\ParkingUnitResource\Pages\ListParkingUnit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ParkingUnitOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListParkingUnit::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Parking Unit Allocated', $this->getPageTableQuery()->whereHas('parking', function (Builder $query) {
                $query->where('type', 'resident');
            })->count()),
            Stat::make('Total Parking Unit Extra', $this->getPageTableQuery()->whereHas('parking', function (Builder $query) {
                $query->where('type', 'reserved');
            })->count()),
        ];
    }
}
