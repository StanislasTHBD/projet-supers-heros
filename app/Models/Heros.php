<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heros extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'incidents',
        'latitude',
        'longitude',
        'phone_number'
    ];

    public function incidents()
    {
        return $this->belongsToMany(Incidents::class);
    }

}
