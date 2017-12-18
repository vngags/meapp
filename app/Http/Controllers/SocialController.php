<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\Social;
use App\User;
use App\Profile;
use FunctionHelper;

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
            //replace new avatar if change
            $new_avatar = FunctionHelper::save_social_avatar($user->avatar, $user->name);
            if($new_avatar) {
                $user_email->delete_avatar();
                $user_email->update([
                    'avatar' => $new_avatar
                ]);                
            }           
            //Check provider name in socials
            $profile = Profile::firstOrCreate(
                ['user_id' => $user_email->id]
            );           
            $social = Social::firstOrCreate([
                'user_id' => $user_email->id,
                'provider_id' => $user->id,
                'provider' => $provider
            ]);
            Auth::loginUsingId($user_email->id); 
            return redirect('/');     
        }else{
            //create new user
            $user_code = FunctionHelper::generate_usercode();
            $avatar = FunctionHelper::save_social_avatar($user->avatar, $user->name);  
            $u = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'slug' => $user_code, 
                'user_code' => $user_code,
                'gender' => isset($user->user['gender']) ? $user->user['gender'] : 'male',
                'avatar' => $avatar
            ]);
            $u->assignRole('writer');
            //create new socials
            Social::create([
                'user_id' => $u->id,
                'provider_id' => $user->id,
                'provider' => $provider
            ]);
            Auth::loginUsingId($u->id);    
            return redirect('/');
        }
    }

}
