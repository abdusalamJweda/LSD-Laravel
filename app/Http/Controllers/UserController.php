<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //not tested yet
    public function update(Request $request){
        $validated = $request->validate([
            'id' => 'required',
            'name' => '',
            'email' => '',
            'bio' => '',
            'sex' => '',
            'date_of_birth' => '',
        ]);
        if($request->user()->id == $validated['id']){
            return response()->json(User::find($validated['id'])->update($validated),200);
        }else{
            return response()->json([
                'message' => 'ماتقدرش :('
            ], 401);
        }
    }
    public function getById(Request $request){
        $validated = $request->validate([
            'id' => 'required',
        ]);
        return response()->json(User::find($validated['id']), 200);
    }
}
