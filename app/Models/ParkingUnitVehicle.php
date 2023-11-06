<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingUnitVehicle extends Model
{
    use HasFactory;

    protected $table = 'parking_unit_vehicles';
    protected $fillable = ['plate_number','model','color','registration_date'];
}
