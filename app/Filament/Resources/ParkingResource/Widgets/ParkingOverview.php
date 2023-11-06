<?php

namespace App\Filament\Resources\ParkingResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Filament\Resources\ParkingResource\Pages\ManageParkings;

class ParkingOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ManageParkings::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Parkings', $this->getPageTableQuery()->count()),
            Stat::make('Total Parkings occupied', $this->getPageTableQuery()->where('status', 'occupied')->count()),
            Stat::make('Total Parkings available', $this->getPageTableQuery()->where('status', 'available')->count()),
        ];
    }
}
