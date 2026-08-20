<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\User;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildings = Building::all();
        return response()->json([
            'message' => 'Get all buildings successfully!',
            'buildings' => $buildings
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
        ]);
        $building = Building::create($validated);
        return response()->json([
            'message'=>'Created Building successfully!!',
            'building'=>$building,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        return response()->json([
            'message'=>'Get building by ID successfully!!',
            'building'=>$building,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name'=>'required|string',
        ]);
        $building->update($validated);
        return response()->json([
            'message'=>'Updated building successfully!',
            'building'=>$building
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return response()->json([
            'message'=>'Deleted building successfully!',
        ]);
    }
}
