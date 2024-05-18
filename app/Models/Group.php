<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','sp','tier1','tier2','tier3','ssm_number','address','phone','email','website'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getAccessibleTiers()
    {
        $tiers = [];
        if ($this->tier1) $tiers[] = 'Tier 1';
        if ($this->tier2) $tiers[] = 'Tier 2';
        if ($this->tier3) $tiers[] = 'Tier 3';
        return $tiers;
    }
}
