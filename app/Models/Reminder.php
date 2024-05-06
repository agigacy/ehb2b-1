<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = ['flight_ticket_id','booking_id','user_id','date','before','title','info'];

    protected $casts = [
        'before' => 'integer',
        // other casts...
    ];

    public function flight_ticket()
    {
        return $this->belongsTo(FlightTicket::class, 'flight_ticket_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
