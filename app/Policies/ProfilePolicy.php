<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    // public function before(User $user)
    // {
    //     if ($user->hasRole('Admin')) {
    //         return true;
    //     }
    // }

    /**
     * Determine whether the user can view the profile.
     *
     * @param  \App\User  $user
     * @param  \App\Profile  $profile
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    public function upload(User $user, Profile $profile)
    {
        return $user->hasPermissionTo('create-profile') && $user->id === $profile->user_id;
    }


    /**
     * Determine whether the user can update the profile.
     *
     * @param  \App\User  $user
     * @param  \App\Profile  $profile
     * @return mixed
     */
    public function update(User $user, Profile $profile)
    {
        return $user->hasPermissionTo('edit-profile') && $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can delete the profile.
     *
     * @param  \App\User  $user
     * @param  \App\Profile  $profile
     * @return mixed
     */
    public function delete(User $user, Profile $profile)
    {
        return $user->hasPermissionTo('delete-profile') && $user->id === $profile->user_id;
    }
}
