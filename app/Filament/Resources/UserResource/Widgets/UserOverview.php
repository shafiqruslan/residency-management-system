<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class UserOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListUsers::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total User', $this->getPageTableQuery()->count()),
            Stat::make('Total Staff Active', $this->getPageTableQuery()->role('staff')->whereHas('userProfile', function (Builder $query) {
                $query->where('status', 'active');
            })->count()),
            Stat::make('Total Resident Active', $this->getPageTableQuery()->role('resident')->whereHas('userProfile', function (Builder $query) {
                $query->where('status', 'active');
            })->count())
        ];
    }
}
