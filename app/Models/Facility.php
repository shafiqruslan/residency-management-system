<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'facilities';
    protected $fillable = ['name', 'description','price_per_hour','image'];
    protected $casts = [
        'image' => 'array',
    ];

    protected static function booted(): void
    {
        static::updating(function (Facility $facility) {
            if($facility->isDirty('image')) {
                $old_image = $facility->getOriginal('image');
                if (!is_null($old_image) && Storage::disk('public')->exists($old_image)) {
                    Storage::disk('public')->delete($old_image);
                }
            }
        });

        static::deleting(function (Facility $facility) {
            if (!is_null($facility->image) && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }
        });
    }


}
