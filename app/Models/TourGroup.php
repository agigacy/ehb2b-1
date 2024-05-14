<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_group_name',
        'tour_group_name_chinese',
        'tour_img_url',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'tour_group_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
