<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id','user_id','date','total','status'];

    // protected $casts = [
    //     'passengers' => 'array',
    // ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}
