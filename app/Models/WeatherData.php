<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'source', 'temperature', 'humidity', 'wind_speed', 'timestamp'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
