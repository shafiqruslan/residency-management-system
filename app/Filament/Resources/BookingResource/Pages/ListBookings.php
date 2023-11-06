<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\BookingResource\Widgets;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBookings extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\BookingOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'today' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date', now()->format('Y-m-d'))),
            'booked' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'booked')),
            'completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
            'cancelled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled')),
        ];
    }

}
