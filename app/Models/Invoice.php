<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceItem;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['number','due_date','total_amount','status','unit_id'];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
