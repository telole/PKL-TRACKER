<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function Register(Request $request){
        $validator = Validator::make($request->all(), [
            "username" => "required|string|max:50|unique:users,username",
            "password" => "required|string|min:6|accepted",
            "email"=> "required|email|regex:users,email",
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
    }
}
