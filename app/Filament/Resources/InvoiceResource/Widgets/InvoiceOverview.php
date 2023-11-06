<?php

namespace App\Filament\Resources\InvoiceResource\Widgets;

use App\Filament\Resources\InvoiceResource\Pages\ListInvoices;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class InvoiceOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListInvoices::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total invoices', $this->getPageTableQuery()->count()),
            Stat::make('Total sent invoices', $this->getPageTableQuery()->where('status', 'sent')->count()),
            Stat::make('Total overdue invoices', $this->getPageTableQuery()->where('status', 'overdue')->count()),
        ];
    }
}
