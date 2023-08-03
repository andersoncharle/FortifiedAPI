<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = "code with anderson";
        return response()->json($data, 200);
    }

    public function registration(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return response()->json([
                'status' => 'Request was successful',
                'message' => 'User Created Successfully,Login to access the application',
                'data' => $user
            ], 201);
        }
        return response()->json([
            'status' => 'Error has occurred && Registration Failed...',
            'message' => 'An error has occurred during registration. Please try again.'
        ], 401);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            //    unauthorized user
            return response()->json([
                'status' => 'Error has occurred...',
                'message' => 'Email & Password does not match with out record.'
            ], 401);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('Api Token of ' . $user->name)->plainTextToken;

        return response()->json([
            'status' => 'Request was successful',
            'message' => 'User Logged in Successfully',
            'data' => $user,
            "token" => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
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
