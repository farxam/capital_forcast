<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = Location::create($request->only('name', 'latitude', 'longitude'));

        return response()->json($location, 201);
    }

    public function index()
    {
        $locations = Location::all();
        return response()->json($locations);
    }
}
