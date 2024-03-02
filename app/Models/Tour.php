<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = ['package_name','package_name_chinese','airline','code','departure_date','return_date','sp','tier1','tier2','tier3','sp_c','tier1_c','tier2_c','tier3_c','tier1_c','country_id','min_g','remark'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }

    public function flight_tickets()
    {
        return $this->belongsToMany(FlightTicket::class);
    }
}