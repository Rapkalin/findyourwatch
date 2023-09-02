<?php

namespace App\Http\Controllers;

use App\Services\GoogleShoppingService;
use Laravel\Socialite\Facades\Socialite;

class ProductController extends Controller
{
    protected $googleShoppingService;

    public function __construct(GoogleShoppingService $googleShoppingService)
    {
        $this->googleShoppingService = $googleShoppingService;
    }

    public function show()
    {

        dump('fetch', $this->fetchGoogleProducts());
        die();
        return view('text');
    }

    public function fetchGoogleProducts()
    {
        // Obtenez un jeton d'accès OAuth2 si ce n'est pas déjà fait.
        $accessToken = $this->getAccessToken(); // Vous devrez implémenter cette méthode.

        // Appelez la fonction fetchProducts de GoogleShoppingService.
        $products = $this->googleShoppingService->fetchProducts($accessToken);

        // Traitez les produits récupérés comme vous le souhaitez.
        // Par exemple, retournez-les comme réponse JSON.
        return response()->json($products);
    }

    // Vous devrez implémenter la méthode getAccessToken pour obtenir le jeton OAuth2.
    protected function getAccessToken()
    {
        try {
            // Utilisez le fournisseur "google" que vous avez configuré dans config/services.php.
            $user = Socialite::driver('google')->stateless()->user();

            // Vous pouvez accéder au jeton d'accès OAuth2 de l'utilisateur.
            $accessToken = $user->token;

            return $accessToken;
        } catch (\Exception $e) {
            dump('e', $e->getMessage());
            die();
            // Gérez les exceptions liées à l'authentification ici.
            return null;
        }
    }

}
