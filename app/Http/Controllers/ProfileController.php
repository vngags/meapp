<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;


class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($slug)
    {        
        $user = User::where('slug', $slug)->first();
        return view('auth.profile')->withUser($user);
    }

    public function edit($user_slug)
    {
        $user = User::findBySlug($user_slug);
        $profile = $user->profile;
        $this->authorize('update', $user);
        return view('auth.profile-edit')->withUser($user);
    }

    public function list()
    {
        $users = User::all();
        return view('auth.user-list')->withUsers($users);
    }

    public function get_notifications()
    {
        $nots = Auth::user()->notifications;
        Auth::user()->unreadNotifications->markAsRead();
        return view('auth.notifications')->withNotifications($nots);
    }
}
