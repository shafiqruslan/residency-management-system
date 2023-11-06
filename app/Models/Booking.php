<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'facility_id','date','start_time','end_time','status','total_price'];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIsBooked($query, $facilityId, $date, $startTime, $endTime)
    {
        $query->where('facility_id', $facilityId)
            ->where('status', 'booked')
            ->where('date', $date)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime);
    }
}
