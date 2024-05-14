<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightTicketPassenger extends Model
{
    use HasFactory;

    protected $table = 'flight_ticket_passenger';

    protected $fillable = [
        'flight_ticket_id',
        'passenger_id',
    ];
}
