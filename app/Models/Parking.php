<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'type','name','status'];

    public function units()
    {
        return $this->belongsTo(Unit::class);
    }
}
