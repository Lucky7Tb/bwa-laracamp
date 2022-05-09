<?php

namespace App\Http\Controllers\User;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        $user = User::firstOrCreate(['email' => $userCallbackData['email']], [
            'name' => $userCallbackData->getName(),
            'email' => $userCallbackData->getEmail(),
            'avatar' => $userCallbackData->getAvatar(),
            'email_verified_at' => now(),
        ]);

        Auth::login($user, true);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
