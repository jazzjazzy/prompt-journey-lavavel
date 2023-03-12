<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SocialiteController extends Controller
{
    /**
     * @param $provider
     * @return mixed
     */
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback($provider) {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $user = User::where(['provider_id' => $socialUser->getId(), 'provider' => $provider])->first();

        if(!$user){
            $validator = Validator::make(
                ['email' => $socialUser->getEmail()],
                ['email' => 'unique:users,email'],
                ['email.unique' => 'This email is already registered.']
            );

            if($validator->fails())
                return redirect('/login')->withErrors($validator);

            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
                'email_verified_at' => now()
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
