<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $document = reports::with('internship.students.users')->get();

        return response()->json([
            "data" => $document
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
        $user = Auth::user();

    if ($user->role !== 'teacher') {
        return response()->json([
            "message" => "Access Denied"
        ], 403);
    }

    $request->validate([
        'status' => 'required|in:terkirim,disetujui,ditolak',
    ]);

    $report = reports::find($id);

    if (!$report) {
        return response()->json([
            "message" => "Data Not Found"
        ], 404);
    }

    $report->update([
        'status' => $request->status
    ]);

    return response()->json([
        "message" => "Status laporan berhasil diperbarui",
        "data" => $report
    ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $reports = reports::find($id);
        if(!$reports) {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }

        $reports->delete();
        return response()->json([
            "message" => "data Deleted Successfully"
        ]);
    }
}
