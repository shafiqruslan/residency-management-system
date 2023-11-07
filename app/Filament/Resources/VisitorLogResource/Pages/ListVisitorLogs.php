<?php

namespace App\Filament\Resources\VisitorLogResource\Pages;

use App\Filament\Resources\VisitorLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\VisitorLogResource\Widgets;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListVisitorLogs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = VisitorLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\VisitorLogOverview::class,
        ];
    }


    public function getTabs(): array
    {
        return [
            'today' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('arrival_time', [now()->startOfDay(),now()->endOfDay()])),
            'checked in' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('arrival_time', [now()->startOfDay(),now()->endOfDay()])->where('status', 'checked_in')),
            'checked out' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'checked_out'))
        ];
    }

}
