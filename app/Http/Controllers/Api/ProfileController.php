<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class ProfileController extends Controller
{
    public function index($slug)
    {
        $user = User::findBySlug($slug);
        return $user->_get_index();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'slug' => 'required',
            'profile.*' => 'nullable'
        ]);
        $user = Auth::user();
        $user->update([
            'slug' => $request->slug
        ]);
        $user->profile()->update($request->profile);
        return $user;
    }

    public function get_unread_notifications(Request $request)
    {
        return $request->user()->unreadNotifications;
    }
    
}
