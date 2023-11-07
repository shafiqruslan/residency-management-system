<?php

namespace App\Filament\Resources\VisitorResource\Widgets;

use App\Filament\Resources\VisitorResource\Pages\ListVisitors;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class VisitorOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListVisitors::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Visitor', $this->getPageTableQuery()->count())
        ];
    }
}
