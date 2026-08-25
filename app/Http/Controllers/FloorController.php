<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $floors = Floor::all();
        return response()->json([
            'message'=>'Get all floors succesfully!',
            'floors'=>$floors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'floor_number'=>'required|string|max:50|unique:floors,floor_number',
            'building_id'=>'required|integer|exists:buildings,id'
        ]);
        
        $floor = Floor::create($validated);
        return response()->json([
            'message'=>'Floor created successfully!',
            'floor'=>$floor
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Floor $floor)
    {
        return response()->json([
            'message'=>'Get floor by Id successfully',
            'floor'=>$floor,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Floor $floor)
    {
        $validated = $request->validate([
            'floor_number'=>'required|string|max:50',
            'building_id'=>'required|integer|exists:buildings,id'
        ]);
        
        $floor->update($validated);
        return response()->json([
            'message'=>'Floor updated successfully!',
            'floor'=>$floor
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Floor $floor)
    {
        $floor->delete();
        return response()->json([
            'message'=>'Deleted floor successfully!',
        ], 200);
    }
}
