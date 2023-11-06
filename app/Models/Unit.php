<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resident;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'type' ,'status'];

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function parkingUnits()
    {
        return $this->hasMany(ParkingUnit::class);
    }
}
