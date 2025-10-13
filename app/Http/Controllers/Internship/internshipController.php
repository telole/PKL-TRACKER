<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use App\Models\internships;
use Illuminate\Http\Request;

class internshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $student = auth()->user()->student;
        $students = $student->id;
        $intern = internships::with(['company', 'reports', 'students', 'teacher', 'supervisor.user'])->where('student_id', $students)->get();

        return response()->json([
            'data' => $intern
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $student = auth()->user()->student;
        $validator = $request->validate([ 
        'company_id' => 'required|exists:companies,id',
        'teacher_id' => 'required|exists:teachers,id',
        'supervisor_id' => 'required|exists:supervisors,id',
        'title' => 'nullable|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|string|in:pending,approved,in_progress,finished',
        'notes' => 'nullable|string',
        'report_submitted' => 'boolean'
        ]);

        $validator['student_id'] = $student->id;

        $internship = internships::create($validator);
        return response()->json([
            "Successssss" => $internship
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
