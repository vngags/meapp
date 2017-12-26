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
        $profile = $user->profile;
        if($user->can('view', $profile)) {
            return view('auth.profile')->withUser($user);
        }
        return redirect('/');
    }

    public function edit($user_slug)
    {
        $user = User::findBySlug($user_slug);
        $profile = $user->profile;
        if($user->can('update', $profile)) {
            return view('auth.profile-edit')->withUser($user);
        }
        return redirect('/');
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
