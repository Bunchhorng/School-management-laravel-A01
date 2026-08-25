<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::all();
        return response()->json([
            'message'=> 'Get all teachers successfully!',
            'teachers'=> $teachers
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:100',
            'age'=>'nullable|integer',
            'subject'=>'nullable|string|max:100',
            'image'=>'nullable|mimes:png,jpg,webp,jpeg,svg|max:2048',
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('teachers', 'public');

            $validated['image'] = $path;
        }

        $teacher = Teacher::create($validated);
        return response()->json([
            'message'=>'Created teacher successfully!',
            'teacher'=>$teacher
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return response()->json([
            'message'=>'Get teacher by id successful',
            'teacher'=>$teacher
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name'=>"required|string|max:100",
            'age'=>'nullable',
            'subject'=>'nullable|string|max:100',
            'image'   => 'nullable|file|image|mimes:png,jpg,webp,jpeg,svg|max:2048',
        ]);

        if($request->hasFile('image')){
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            
            $validated['image'] = $request->file('image')->store('teachers', 'public');
        }else{
            unset($validated['image']);
        }
        $teacher->update($validated);
        return response()->json([
            'message'=>'updated teacher successfull',
            'teacher'=>$teacher
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,Teacher $teacher)
    {
        if($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }
        
        $teacher->delete();
        return response()->json([
            'message'=>"delete successful"
        ]);
    }
}
