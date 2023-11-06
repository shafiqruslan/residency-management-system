<?php

namespace App\Filament\Resources\BookingResource\Widgets;

use App\Filament\Resources\BookingResource\Pages\ListBookings;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListBookings::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Booked today', $this->getPageTableQuery()->where('date', now()->format('Y-m-d'))->where('status', 'booked')->count()),
            Stat::make('Total Completed today', $this->getPageTableQuery()->where('date', now()->format('Y-m-d'))->where('status', 'completed')->count()),
            Stat::make('Total Cancelled today', $this->getPageTableQuery()->where('date', now()->format('Y-m-d'))->where('status', 'cancelled')->count())
        ];
    }
}
