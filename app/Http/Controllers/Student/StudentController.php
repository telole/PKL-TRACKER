<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $student = students::with('users', 'internshps.company')->get();

        return response()->json([
            "student" => $student
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:5',
            'full_name' => 'required|string|max:200',
            'email' => 'nullable|email|max:150',
            'nis' => 'required|string|max:50|unique:students',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'KELAS' => 'nullable|string|max:100',
            'photo_path' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password_hash' => Hash::make($request->password),
            'role' => 'student',
            'full_name' => $request->full_name,
            'email' => $request->email,
            'is_active' => 1,
        ]);

        students::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'class' => $request->class,
            'major' => $request->major,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo_path' => $request->photo_path,
            'KELAS' => $request->KELAS,
        ]);

        return response()->json([
            'message' => 'Akun siswa berhasil dibuat.',
            'user' => $user,
        ], 201);
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
