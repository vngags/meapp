<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'user_code', 'avatar', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function _get_index()
    {
        $user = $this->with('profile')->where('id', $this->id)->first();
        
        $userData = [
            'uid' => $user->user_code,
            'name' => $user->name,
            'slug' => $user->slug,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'gender' => $user->gender,
            'profile' => [
                'about' => $user->profile->about,
                'phone_number' => $user->profile->phone_number
            ]
        ];
        return json_encode($userData);
    }

    public function social()
    {
        return $this->hasOne(Social::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
