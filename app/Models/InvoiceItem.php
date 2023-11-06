<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['fee_id','unit_id','quantity','total_price','due_date'];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
