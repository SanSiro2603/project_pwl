<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'studio_id', 'date', 'start_time', 
        'end_time', 'is_available'
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'studio_id', 'studio_id')
                    ->where('booking_date', $this->date)
                    ->where('start_time', $this->start_time);
    }
}
