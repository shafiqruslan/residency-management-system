<?php

namespace App\Filament\Resources\UnitResource\Widgets;

use App\Filament\Resources\UnitResource\Pages\ListUnits;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class UnitOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListUnits::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Unit', $this->getPageTableQuery()->count()),
            Stat::make('Total Unit Occupied', $this->getPageTableQuery()->where('status', 'occupied')->count()),
            Stat::make('Total Unit Available', $this->getPageTableQuery()->where('status', 'available')->count())
        ];
    }
}
