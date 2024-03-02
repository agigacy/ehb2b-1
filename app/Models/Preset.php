<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    use HasFactory;

    protected $fillable = ['name','price'];

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class);
    }
}
