<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Widgets;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListUsers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\UserOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'staff' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function (Builder $query) {
                    $query->where('name', 'staff');
                })),
            'resident' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function (Builder $query) {
                    $query->where('name', 'resident');
                })),
        ];
    }


}
