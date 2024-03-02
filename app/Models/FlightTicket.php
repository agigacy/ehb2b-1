<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightTicket extends Model
{
    use HasFactory;

    protected $fillable = ['pnr','airline','departure_date','return_date','from','to','seat'];

    public function tours()
    {
        return $this->belongsToMany(Tour::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'reminder_id');
    }
}
