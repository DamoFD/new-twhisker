<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\AllPostsCollection;
use App\Services\FileService;

class UserController extends Controller
{

    public function show($id)
    {
        $user = User::find($id);
        if ($user === null) {
            return redirect()->route('home.index');
        }

        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $followings = $user->followings;
        $followers = $user->followers;

        return Inertia::render('User', [
            'user' => $user,
            'postsByUser' => new AllPostsCollection($posts),
            'followings' => $followings,
            'followers' => $followers,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([ 'file' => 'required|mimes:jpg,jpeg,png' ]);
        $user = (new FileService)->updateFile(auth()->user(), $request, 'user');
        $user->save();

        return redirect()->route('users.show', ['id' => auth()->user()->id]);
    }
}
