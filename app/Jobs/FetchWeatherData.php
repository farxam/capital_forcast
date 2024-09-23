<?php

namespace App\Jobs;

use App\Models\Location;
use App\Models\WeatherData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchWeatherData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function handle()
    {
        $weatherSources = [
            'openweather' => 'https://api.openweathermap.org/data/2.5/weather?lat=' . $this->location->latitude . '&lon=' . $this->location->longitude . '&appid=YOUR_API_KEY',
            'weatherapi' => 'http://api.weatherapi.com/v1/current.json?key=YOUR_API_KEY&q=' . $this->location->latitude . ',' . $this->location->longitude
        ];

        foreach ($weatherSources as $source => $url) {
            $response = Http::get($url);
            if ($response->successful()) {
                $data = $this->parseResponse($response->json(), $source);
                WeatherData::create($data);
            }
        }
    }

    protected function parseResponse($response, $source)
    {
        if ($source == 'openweather') {
            return [
                'location_id' => $this->location->id,
                'source' => $source,
                'temperature' => $response['main']['temp'],
                'humidity' => $response['main']['humidity'],
                'wind_speed' => $response['wind']['speed'],
                'timestamp' => now(),
            ];
        } elseif ($source == 'weatherapi') {
            return [
                'location_id' => $this->location->id,
                'source' => $source,
                'temperature' => $response['current']['temp_c'],
                'humidity' => $response['current']['humidity'],
                'wind_speed' => $response['current']['wind_kph'],
                'timestamp' => now(),
            ];
        }
    }
}
