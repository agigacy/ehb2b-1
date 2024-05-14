<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = ['airline','code','departure_date','return_date','sp','tier1','tier2','tier3','sp_c','tier1_c','tier2_c','tier3_c','tour_group_id','min_g','remark'];

    // public function country()
    // {
    //     return $this->belongsTo(Country::class, 'country_id');
    // }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function flight_tickets()
    {
        return $this->belongsToMany(FlightTicket::class);
    }

    public function tour_group()
    {
        return $this->belongsTo(TourGroup::class, 'tour_group_id');
    }
}

