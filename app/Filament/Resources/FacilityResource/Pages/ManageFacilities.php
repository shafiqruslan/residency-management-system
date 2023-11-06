<?php

namespace App\Filament\Resources\FacilityResource\Pages;

use App\Filament\Resources\FacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFacilities extends ManageRecords
{
    protected static string $resource = FacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth('xl')
            ->mutateFormDataUsing(function (array $data): array {
                $data['price_per_hour'] = $data['price'] * 100;

                return $data;
            }),
        ];
    }

}
