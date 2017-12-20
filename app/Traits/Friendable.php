<?php

namespace App\Traits;

use App\Friendship;

trait Friendable
{
    public function isFollowing($uid)
    {
        $following = Friendship::where('user_id', $uid)
                    ->where('follower_id', $this->uid)
                    ->first();
        
        if($following) {
            return 1;
        }
        return 0;
    }

    public function addFollowing($uid)
    {

        if($this->isFollowing($uid)) {
            return 0;
        }
        if($this->uid === $uid) {
            return 0;
        }

        $following = Friendship::create([
            'user_id' => $uid,
            'follower_id' => $this->uid
        ]);
        if($following) {
            return 1;
        }
        return 0;
    }

    public function removeFollowing($uid)
    {
        $following = Friendship::where('user_id', $uid)
                    ->where('follower_id', $this->uid)
                    ->first();
        if($following) {
            $following->delete();
            return 1;
        }
        return 0;
    }

    public function getFollowings()
    {
        $users = array();
        $followings = Friendship::where('follower_id', $this->uid)->get();
        foreach($followings as $uid) {
            array_push($users, \App\User::where('uid', $uid)->_get_index());
        }
        return $users;
    }

    public function getFollowers()
    {
        $users = array();
        $followers = Friendship::where('user_id', $this->uid)->get();
        foreach ($followers as $uid) {
            array_push($users, \App\User::where('uid', $uid)->_get_index());
        }
        return $users;
    }
}