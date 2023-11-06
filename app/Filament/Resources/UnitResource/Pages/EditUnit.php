<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Parking;

class EditUnit extends EditRecord
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->data;

        if(!empty($data['parkings'])) {
            foreach($data['parkings'] as $parking) {
                Parking::find($parking)->update([
                    'status' => 'occupied'
                ]);
            }
        }
    }
}
