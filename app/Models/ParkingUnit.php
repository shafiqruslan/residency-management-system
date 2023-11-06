<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingUnit extends Model
{
    use HasFactory;

    protected $table = 'parking_unit';
    protected $fillable = ['parking_id', 'unit_id'];

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function vehicle()
    {
        return $this->hasOne(ParkingUnitVehicle::class);
    }
}
