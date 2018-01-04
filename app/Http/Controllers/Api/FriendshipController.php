<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\AddFollow;
use App\User;
use Auth;

class FriendshipController extends Controller
{
    public function check_following(Request $request)
    {
        $this->validate($request, [
            'user_slug' => 'required'
        ]);
        $user = User::findBySlug($request->user_slug);
        if(Auth::user()->isFollowing($user->uid) == 1) {
            return ['status' => 'following'];
        }
        return ['status' => 0];
    }

    public function add_following(Request $request)
    {
        $this->validate($request, [
            'user_slug' => 'required'
        ]);
        $user = User::findBySlug($request->user_slug);        
        if($request->user()->addFollowing($user->uid) == 1) {
            $user->notify(new AddFollow(Auth::user()));           
            return ['status' => 'following'];
        }
        return ['status' => 0];
    }

    public function remove_following(Request $request)
    {
        $this->validate($request, [
            'user_slug' => 'required'
        ]);
        $user = User::findBySlug($request->user_slug);
        if(Auth::user()->removeFollowing($user->uid) == 1) {
            return ['status' => 'removed'];
        }
        return ['status' => 0];
    }
}
