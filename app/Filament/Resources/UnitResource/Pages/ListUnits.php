<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\UnitResource\Widgets;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUnits extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\UnitOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'studio' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 1)),
            'condo' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 2)),
            'penthouse' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 3)),
            'duplex' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 4)),
        ];
    }
}
