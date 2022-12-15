<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
        /**
    * register User.
    *
    * /**
    * @OA\Info(title="My First API", version="0.1")
    *
    * @OA\Post(
    *     path="/auth/signup",
    *     operationId="addUser",
    *     @OA\Response(
    *         response=405,
    *         description="Invalid input"
    *     ),
    * )
    */
    public function signup(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed',
            'sex' => 'required',
            'date_of_birth' => 'required',
            'bio' => '',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'sex' => $validated['sex'],
            'date_of_birth' => $validated['date_of_birth'],
            'type' => 'user',
            'bio' => $validated['bio']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'bio' => $user->bio,
        ], 200);
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if(Auth::attempt($validated)){
            //logged in
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'bio' => $user->bio,
            ], 200);
        }else{
            return response()->json([
                'message' => 'الإيميل ولا كلمة السر غلط',
            ], 401);
        }
        
    }
    public function loginWithToken(Request $request){
        $token = $request->user()->createToken('token')->plainTextToken;
        return response()->json([
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'bio' => $request->user()->bio,
        ], 200);
        return $request->user();
    }

    public function logout(Request $request){
        return $request->user()->currentAccessToken()->delete();
    }

    
}
