<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
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
