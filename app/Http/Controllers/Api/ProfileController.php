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
        $user = User::where('slug', $slug)->first();
        return $user->_get_index();
    }
}
