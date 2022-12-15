<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\User;
use App\Models\Bookmark;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMemeRequest;
use App\Http\Requests\UpdateMemeRequest;
use Illuminate\Support\Facades\DB;

class MemeController extends Controller
{

    public function index()
    {
        //
    }
    public function addToBookmarks(Request $request){
        // return $request->user()->bookmarks;
        $user = $request->user();
        $validated = $request->validate([
            'meme_id' => 'required'
        ]);
        $validated['user_id'] = $user->id;
        
        if(property_exists($user->bookmarks, $validated['meme_id'])){
            return 0;
        }
        return BookMark::insert($validated);
    }
    public function removeFromBookmarks(Request $request){
        $validated = $request->validate([
            'meme_id' => 'required'
        ]);
        $validated['user_id'] = $request->user()->id;

        return BookMark::where('meme_id',$validated['meme_id'])->where('user_id', $validated['user_id'])->delete();
    }
    public function newsFeed(Request $request){
        $memes = Meme::all();
        return response()->json($memes, 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'city' => 'required',
            'type' => 'required',
            'example' => 'required',
        ]);
        $validated['user_id'] = $request->user()->id;
        $meme = Meme::create($validated);
        return $meme;
    }
    public function show(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required'
        ]);

        return Meme::find($validated['id']);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'body' => 'required',
            'city' => 'required',
            'type' => 'required',
            'example' => 'required',
        ]);
        $meme = Meme::find($validated['id'])->update($validated);
        return $meme;
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'meme_id' => 'required'
        ]);
        // return $validated['meme_id'];
        $meme = Meme::find($validated["meme_id"]);
        if($meme != null){
        return $meme->delete();
        }
        return 'مش موجود';
    }
}
