<?php

namespace App\Filament\Resources\VisitorLogResource\Widgets;

use App\Filament\Resources\VisitorLogResource\Pages\ListVisitorLogs;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class VisitorLogOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListVisitorLogs::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total visitor today', $this->getPageTableQuery()->whereBetween('arrival_time', [now()->startOfDay(),now()->endOfDay()])->count()),
            Stat::make('Total visitor not checked out', $this->getPageTableQuery()->where('status', 'checked_in')->count())
        ];
    }
}
