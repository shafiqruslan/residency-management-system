<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title','content'];

    public function units()
    {
        return $this->belongsToMany(Unit::class);
    }
}
