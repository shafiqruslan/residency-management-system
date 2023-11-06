<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Unit;
use App\Models\Fee;
use Illuminate\Database\Eloquent\Model;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $units = Unit::find($data['units'])->where('status', 'occupied');
        $fees = Fee::find($data['fees']);

        foreach ($units as $unit) {
            $invoiceItems = [];

            foreach ($fees as $fee) {
                $amount = $fee->base_amount;

                if($fee->id == 1) {
                    $totalAmount = $amount * $unit->size;
                    $quantity = $unit->size;
                } elseif($fee->id == 2) {
                    $totalAmount = $amount * $unit->parkingUnits->count();
                    $quantity = $unit->parkingUnits->count();
                } else {
                    $totalAmount = $amount * 1;
                    $quantity = 1;
                }

                $invoiceItems[] = [
                    'fee_id' => $fee->id,
                    'unit_id' => $unit->id,
                    'quantity' => $quantity,
                    'total_price' => $totalAmount,
                ];
            }
        }

        $totalPriceArr = array_column($invoiceItems, 'total_price');

        $totalAmountSum = array_sum($totalPriceArr);

        // Create the Invoice model
        $invoice = static::getModel()::create([
            'number' => '001',
            'due_date' => $data['due_date'],
            'total_amount' => $totalAmountSum,
            'unit_id' => $unit->id,
        ]);

        $invoice->invoiceItems()->createMany($invoiceItems);

        return $invoice;

    }
}
