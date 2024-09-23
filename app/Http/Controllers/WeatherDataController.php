<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherDataController extends Controller
{
    public function getAverage(Request $request, $locationId)
    {
        $location = Location::findOrFail($locationId);
        
        $period = $request->query('period', 7); //7 days

        // cashing
        $cacheKey = "weather_average_{$locationId}_{$period}";
        return Cache::remember($cacheKey, 60 * 60, function () use ($location, $period) {
            $endDate = now();
            $startDate = now()->subDays($period);

            $data = WeatherData::where('location_id', $location->id)
                                ->whereBetween('timestamp', [$startDate, $endDate])
                                ->get();

            if ($data->count() == 0) {
                return response()->json(['message' => 'No data found'], 404);
            }

            $avgTemp = $data->avg('temperature');
            $avgHumidity = $data->avg('humidity');
            $avgWindSpeed = $data->avg('wind_speed');

            return response()->json([
                'location' => $location->name,
                'average_temperature' => $avgTemp,
                'average_humidity' => $avgHumidity,
                'average_wind_speed' => $avgWindSpeed,
                'period' => $period,
            ]);
        });
    }
}
