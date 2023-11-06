<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\InvoiceResource\Widgets;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListInvoices extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->hidden(Auth::user()->hasRole('resident')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\InvoiceOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'sent' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'sent')),
            'overdue' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'overdue')),
            'paid' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'paid')),
        ];
    }
}
