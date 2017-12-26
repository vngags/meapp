<?php
namespace App\Repositories\Profile;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Collection;

class ProfileEloquentRepository extends EloquentRepository implements ProfileRepositoryInterface
{

    public function getModel()
    {
        return \App\User::class;
    }


    public function getbySlug($slug)
    {        
        $user = $this->_model->with(['profile', 'products'])->where('slug', $slug)->first();
        $userData = $this->filterData($user);
        return json_encode($userData);
    }

    public function getAuth($id)
    {
        $user = $this->_model->with(['profile', 'products'])->where('id', $id)->first();
        $userData = $this->filterData($user);
        $userData['notifications'] = $user->notifications()->paginate(10);
        return json_encode($userData);
    }

    public function filterData($user) {
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
            'permissions' => $user->getAllPermissions()->map(function($permission) {
                return $permission->name;
            }),
            'products' => $user->products,
            'followings' => $user->getFollowings(),
            'followers' => $user->getFollowers()
        ];
        return $userData;
    }


    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if($result) {
            $result->update($attributes);
            $result->profile->update($attributes['profile']);
            return $this->getAuth($id);
        }
        return false;
    }

}
