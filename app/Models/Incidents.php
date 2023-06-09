<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidents extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function heros()
    {
        return $this->belongsToMany(Heros::class);
    }
}
