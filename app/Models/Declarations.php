<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declarations extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'latitude',
        'longitude',
        'incident_id',
    ];

    public function incident()
    {
        return $this->belongsTo(Incidents::class);
    }
}
