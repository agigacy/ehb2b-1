<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerAdditional extends Model
{
    use HasFactory;

    protected $fillable = ['passenger_id','name','value'];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_id');
    }
}
