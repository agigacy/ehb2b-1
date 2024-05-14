<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id','name','passport','passport_upload','designation','date_of_birth','hp','remark'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function presets()
    {
        return $this->belongsToMany(Preset::class);
    }

    public function passenger_additional()
    {
        return $this->hasMany(PassengerAdditional::class);
    }

    public function flight_tickets()
    {
        return $this->belongsToMany(FlightTicket::class);
    }
}
