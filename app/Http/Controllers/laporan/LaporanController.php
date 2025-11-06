<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use App\Models\internships;
use App\Models\reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    $user = Auth::user();

    if ($user->role !== 'student') {
        return response()->json(['message' => 'Akses ditolak'], 403);
    }

   $reports = reports::with([
        'internship.company',
        'internship.teacher',
        'internship.supervisor',
    ])
    ->whereHas('internship.students.users', function ($q) use ($user) {
        $q->where('id', $user->id);
    })
    ->orderBy('created_at', 'desc')
    ->get();

    return response()->json([
        'message' => 'success',
        'data' => $reports
    ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();

        if ($user->role !== 'student') {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $validated = $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'status' => 'nullable|in:dikirim,diperiksa,ditolak,diterima',
        ]);

        $internship = internships::where('id', $validated['internship_id'])
            ->where('student_id', function ($q) use ($user) {
                $q->select('id')->from('students')->where('user_id', $user->id);
            })
            ->first();

        if (!$internship) {
            return response()->json(['message' => 'Data PKL tidak ditemukan'], 404);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('reports', 'public');
        }

        $report = reports::create([
            'internship_id' => $validated['internship_id'],
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'file_path' => $filePath,
            'status' => $validated['status'] ?? 'dikirim',
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diunggah',
            'data' => $report
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
