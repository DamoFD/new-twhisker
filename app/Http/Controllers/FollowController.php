<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([ 'follow_user_id' => 'required' ]);
        $follow = new Follow;

        $follow->user_id = auth()->user()->id;
        $follow->follow_user_id = $request->input('follow_user_id');
        $follow->save();
    }

    public function destroy($id)
    {
        $follow = Follow::find($id);
        if ($follow) {
            $follow->delete();
        }
    }
}
