<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    // Register user
    public function registerUser(Request $request)
    {
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
            // Mail::to($request['email'])->send(new WelcomeMail($user));
            // event(new UserCreated($user));
            return response()->json([
                'response' => $user,
                'message' => 'User created successfully',
                'code' => Response::HTTP_OK
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    // Login user

    public function loginUser(Request $request)
    {
        $loginType = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';
        $credentials = $request->only($loginType, 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-application')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'code' => Response::HTTP_OK
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'credentials' => 'The provided credentials do not match our records.',
                'code' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function followUser(User $follower)
    {
        $user = Auth::user();
        $user->following()->syncWithoutDetaching($follower->id);  // ignoring duplicates

        return response()->json([
            'message' => 'Successfully Followed',
            'code' => Response::HTTP_OK
        ],Response::HTTP_OK);
    }

    public function allUsers()
    {
        return response()->json([
            'response' =>User::all(),
            'code' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
