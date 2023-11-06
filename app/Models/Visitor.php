<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['name','identification_number','contact_num'];

    public function visitorLogs()
    {
        return $this->hasMany(VisitorLog::class);
    }
}
