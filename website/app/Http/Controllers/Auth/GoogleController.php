<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Redirige l'utilisateur vers la page d'authentification Google
    public function redirectToGoogle()
    {
        die('stop');
        return Socialite::driver('google')->redirect();
    }

    // Gère la réponse de Google après l'authentification
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            dump('$user', $user);
            die();

            // Vous pouvez maintenant accéder aux informations de l'utilisateur, telles que $user->name, $user->email, etc.

            // Redirigez l'utilisateur vers la page d'accueil ou effectuez d'autres actions nécessaires.

        } catch (\Exception $e) {
            // Gérez les exceptions liées à l'authentification ici.
            return redirect('/')->with('error', 'Erreur lors de l\'authentification avec Google.');
        }
    }
}
