<?php

namespace App\Filament\Resources\VisitorLogResource\Pages;

use App\Filament\Resources\VisitorLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitorLog extends CreateRecord
{
    protected static string $resource = VisitorLogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['visit_date'] = now()->format('Y-m-d');
        $data ['arrival_time'] = now()->format('H:i:s');
        $data['status'] = 'checked_in';

        return $data;
    }
}
