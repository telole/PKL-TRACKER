<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\students;
use App\Models\supervisors;
use App\Models\teachers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function Register(Request $request){
        $validator = Validator::make($request->all(), [
            "username" => "required|string|max:50|unique:users,username",
            "password" => "required|string|min:6|confirmed",
            "email"=> "required|email|unique:users,email",
            "full_name" => "required|string|max:100",
            'role'=> 'required|in:student,admin,teacher,supervisor'
        ]);

        if($validator->fails()){ 
            return response()->json([
                "message" => "Validation Fails",
                "errors" => $validator->errors()
            ], 422);
        }

        // if($request->role == "teacher")

        $user = User::create([
            'username'      => $request->username,
            'password_hash' => Hash::make($request->password),
            'role'          => $request->role,
            'full_name'     => $request->full_name,
            'email'         => $request->email,
            'is_active'     => 1,
        ]);

        // Tambahan jika role student
        if ($request->role == 'student') {
            students::create([
                'user_id' => $user->id,
                'nis'     => $request->nis,
                'class'   => $request->class,
                'major'   => $request->major,
                'phone'   => $request->phone,
                'address' => $request->address,
            ]);
        }

        // Jika role teacher
        if ($request->role == 'teacher') {
            teachers::create([
                'user_id' => $user->id,
                'nip'     => $request->nip,
                'phone'   => $request->phone,
            ]);
        }

        // Jika role supervisor
        if ($request->role == 'supervisor') {
            supervisors::create([
                'user_id'    => $user->id,
                'company_id' => $request->company_id,
                'position'   => $request->position,
                'phone'      => $request->phone,
            ]);
        }

        return response()->json([
            'message' => 'Registration successful',
            'token' => $user->createToken('auth')->plainTextToken,
            'user'    => $user
        ], 201);
    }

    public function Login(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        $validate = $validator->validate();


        if ($validate->fails()) {
            return response()->json([
                "message" => "error during validation",
                "errors" => $validate->errors()
            ]);
         }

         $user = User::where("email", $request->email)->first();
         if (!$user) {
            
         }
    }
}
