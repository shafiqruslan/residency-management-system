<?php

namespace App\Filament\Resources\AnnouncementResource\Widgets;

use App\Filament\Resources\AnnouncementResource\Pages\ListAnnouncements;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class AnnouncementOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListAnnouncements::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Announcement', $this->getPageTableQuery()->count()),
        ];
    }
}
