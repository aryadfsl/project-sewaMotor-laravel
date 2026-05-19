<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteGoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        $provider = Socialite::driver('google');

        if (app()->environment('local')) {
            $provider->stateless();
        }

        return $provider->redirect();
    }

    public function callback(): RedirectResponse
    {
        $provider = Socialite::driver('google');

        if (app()->environment('local')) {
            $provider->stateless();
        }

        if (request()->missing('code')) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google dibatalkan atau kode login tidak ditemukan. Silakan coba lagi.']);
        }

        try {
            $googleUser = $provider->user();
        } catch (ClientException) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Sesi login Google sudah kedaluwarsa atau sudah digunakan. Silakan klik Login dengan Google lagi.']);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'profile_photo' => $googleUser->getAvatar() ?: $user->profile_photo,
            ])->save();
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User',
                'email' => $googleUser->getEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)),
                'role' => 'user',
                'google_id' => $googleUser->getId(),
                'profile_photo' => $googleUser->getAvatar(),
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('products');
    }
}
