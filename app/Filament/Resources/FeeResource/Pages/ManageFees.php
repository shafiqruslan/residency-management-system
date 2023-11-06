<?php

namespace App\Filament\Resources\FeeResource\Pages;

use App\Filament\Resources\FeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFees extends ManageRecords
{
    protected static string $resource = FeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('xl')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['base_amount'] = $data['base_amount'] * 100;

                    return $data;
                }),
        ];
    }
}
