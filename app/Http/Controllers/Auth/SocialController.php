<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;
use App\Models\User;
use App\Models\UserNetwork;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\InvalidStateException;

class SocialController extends Controller
{
    /**
     *
     *
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    //social
    public function redirectToProvider($provider)
    {

        $result = Socialite::driver($provider)->redirect();
        return $result;
    }

    public function handleProviderCallback($provider)
    {

        try {
            $getInfo = Socialite::driver($provider)->user();

        } catch (InvalidStateException $e) {
            $getInfo = Socialite::driver($provider)->stateless()->user();
        }
        $providerUser = User::where('email', $getInfo->email)->where('status',
            config('common.status_user.active'))->first();

        if ($providerUser) {
            $userNetwork = UserNetwork::where('user_id', $providerUser->id)
                ->where('provider_name', $provider)->first();
            if (!$userNetwork) {
                $accSocialte = UserNetwork::create([
                    'user_id' => $providerUser->id,
                    'provider_id' => $getInfo->id,
                    'provider_name' => $provider
                ]);
            }
            Auth::login($providerUser);
            return redirect()->route('home.index');
        } else {
            return redirect()->route('login');
        }
    }
}
