<?php

namespace App\Filament\Resources\ParkingResource\Pages;

use App\Filament\Resources\ParkingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\ParkingResource\Widgets;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManageParkings extends ManageRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ParkingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('xl'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\ParkingOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'resident' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'resident')),
            'reserved' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'reserved')),
            'visitor' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'visitor')),
        ];
    }
}
