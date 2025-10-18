<?php

namespace App\Http\Controllers\Supervisors;

use App\Http\Controllers\Controller;
use App\Models\supervisors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();

        if($user->role !== 'teacher') {
            return response()->json([
                'message' => 'access Denied'
            ]);
        }
        $supervisors = supervisors::with('companies.internship', 'users')->get();

        return response()->json([
            "message" => "success",
            "data" => $supervisors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $auth = Auth::user();
        if ($auth->role !== 'teacher') {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'full_name' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email',
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|string|max:100',
            'phone' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password_hash' => Hash::make($request->password),
            'role' => 'supervisor',
            'full_name' => $request->full_name,
            'email' => $request->email,
            'is_active' => 1,
        ]);

        Supervisors::create([
            'user_id' => $user->id,
            'company_id' => $request->company_id,
            'position' => $request->position,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'message' => 'Supervisor berhasil ditambahkan dan dapat login.',
            'data' => $user
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // Hanya teacher yang boleh melihat data supervisor
    $auth = Auth::user();
    if ($auth->role !== 'teacher') {
        return response()->json(['message' => 'Access denied'], 403);
    }

    $supervisor = Supervisors::with(['user', 'companies.internship'])->find($id);

    if (!$supervisor) {
        return response()->json(['message' => 'Supervisor tidak ditemukan'], 404);
    }

    return response()->json([
        'message' => 'success',
        'data' => $supervisor
    ]);

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
