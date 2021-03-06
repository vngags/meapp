<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use File;
use Nicolaslopezj\Searchable\SearchableTrait;


use App\Traits\Friendable;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, Friendable, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'uid', 'avatar', 'gender'
    ];

    protected $appends = ['all_permissions','can'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.email' => 10,
            'users.slug' => 2,
            'profiles.about' => 2,
            'profiles.phone_number' => 1,
        ],
        'joins' => [
            'profiles' => ['users.id','profiles.user_id'],
        ],
    ];

    public function getAllPermissionsAttribute()
    {
        return $this->getAllPermissions();
    }

    public function getCanAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if ($this->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        return $permissions;
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->first();
    }

    public function scopeFindByUid($query, $uid)
    {
        return $query->where('uid', $uid)->first();
    }

    public function delete_avatar()
    {
        $avatar = $this->avatar;
        $name = basename($avatar); // return name and ext
        //Get member directory Eg: 1
        $dirname =pathinfo($avatar, PATHINFO_DIRNAME); //return http://coccoc.me/images/1
        $parts = explode('/',$dirname);//create array
        $directory = array_pop($parts); //return Eg: 1
        $filename = $directory . '/' . $name;
        if(File::exists('images/'.$filename)) {
            File::delete('images/'.$filename);
            return 1;
        }
        return 0;
    }

    public function _get_index()
    {
        $user = self::with(['profile', 'products'])->where('id', $this->id)->first();        
        $userData = [
            'uid' => $user->uid,
            'name' => $user->name,
            'slug' => $user->slug,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'gender' => $user->gender,
            'profile' => [
                'about' => isset($user->profile->about) ? $user->profile->about : '',
                'phone_number' => isset($user->profile->phone_number) ? $user->profile->phone_number : ''
            ],
            'rule' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions(),
            'products' => $user->products,
            'followings' => $user->getFollowings(),
            'followers' => $user->getFollowers()
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
