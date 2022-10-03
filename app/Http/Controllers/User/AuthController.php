<?php

namespace App\Http\Controllers\User;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\User\AfterRegister;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.login');
    }

    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginGoogleCallback()
    {
        $userCallbackData = Socialite::driver('google')->stateless()->user();

        $user = User::whereEmail($userCallbackData['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $userCallbackData->getName(),
                'email' => $userCallbackData->getEmail(),
                'avatar' => $userCallbackData->getAvatar(),
                'email_verified_at' => now(),
            ]);
            Mail::to($user->email)->send(new AfterRegister($user));
        }

        Auth::login($user, true);
        return redirect('/');
    }
}
