<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class providerController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try{

            $SocialUser = Socialite::driver($provider)->user();
            if(User::where('email',  $SocialUser->getEmail())->exists()){
            return redirect('/login')->withErrors(['email' =>'this email use different' ]);

            }
            $user = User::updateOrCreate([
                'provider_id' => $SocialUser->id,
                'provider'=>$provider])
                ->first();
            if(!$user){
                $user =  User::create([
                    'name'=>$SocialUser->getName(),
                    'email'=>$SocialUser->getEmail(),
                    'username'=>User::generateUserName($SocialUser->getNickname()),
                        'provoder'=>$provider,
                        'provider_id'=>$SocialUser->getId(),
                        'provider_token'=>$SocialUser->token,
                        'email_verified_at' =>now()

             ]);

            }

        }catch(\Exception $e){
            return redirect('/login');
        }



    }
}
