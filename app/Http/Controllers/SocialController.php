<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\Social;
use App\User;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        //Check email of user has exists in socials?
        $user_email = User::where('email', $user->email)->first();

        if($user_email) {

            //Check provider name in socials

            $social = Social::where('user_id', $user_email->id)->where('provider', $provider)->first();
            
            if($social) {
                //update provider_id and login
                $social->update([
                    'provider_id' => $user->id
                ]);

                //Login by user                
                Auth::loginUsingId($user_email->id);                
            }else{
                //create new socials
                Social::create([
                    'user_id' => $user_email->id,
                    'provider_id' => $user->id,
                    'provider' => $provider
                ]);
                //Login by user                
                Auth::loginUsingId($user_email->id);    
            }
            return redirect()->back();
        }else{
            //create new user
            $user_code = mt_rand(1111111111, 9999999999);
            $u = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'slug' => $user_code, 
                'user_code' => $user_code,
                'gender' => isset($user->user['gender']) ? $user->user['gender'] : 'male',
                'avatar' => $user->avatar
            ]);
            //create new socials
            Social::create([
                'user_id' => $u->id,
                'provider_id' => $user->id,
                'provider' => $provider
            ]);
            Auth::loginUsingId($u->id);    
            return redirect()->back();
        }
    }

}
