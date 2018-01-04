<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Profile\ProfileRepositoryInterface;

class ProfileController extends Controller
{

    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profile = $profileRepository;
    }

    public function index($slug)
    {
        $obj = $this->profile->getBySlug($slug);
        return $obj;
    }

    public function update(Request $request)
    {   
        $this->authorize('update', $request->user()->profile);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'slug' => 'required',
            'profile.*' => 'nullable'
        ]);
        return $this->profile->update($request->user()->id, $request->all());
    }


    public function getAuth(Request $request)
    {
        return $this->profile->getAuth($request->user()->id);
    }
    
}
