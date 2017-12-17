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

    public function get_edit()
    {
        return view('auth.profile-edit')->withUser(Auth::user());
    }
}
