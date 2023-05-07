<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function registerUser(Request $request){
        $rules = [
            'name' => 'required|max:255',
            'username' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255',
            'confirm_password' => 'required|same:password',
        ];
        try {
            // Do something with the validated data
            $request->validate($rules);
            $user = new User();
            $user->save();
            return response()->json([
                'response' => $user,
                'message' => 'User created successfully',
                'code' => 200
            ],200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'code' => '422'
            ],422);
        }
    }
}
