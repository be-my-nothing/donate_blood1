<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'email' => 'required|email|unique:users',
            'city' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'name' => $validatedData['name'],
            'age' => $validatedData['age'],
            'blood_type' => $validatedData['blood_type'],
            'email' => $validatedData['email'],
            'city' => $validatedData['city'],
            'password' => bcrypt($validatedData['password']),
        ]);
    
        $token = $user->createToken('main')->plainTextToken;
    
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
    
     public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }        /** @var \App\Models\User $user */

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
    public function logout(Request $request)
    {
          /**@var \App\Models\MyUserModel $user **/
                //   /** @var User $user */

          $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
    
}
