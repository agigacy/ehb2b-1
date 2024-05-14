<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'img_url'];


    public function tourGroups()
    {
        return $this->hasMany(TourGroup::class);
    }
}
