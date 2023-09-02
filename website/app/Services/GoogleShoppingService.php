<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Middleware\ScopedAccessTokenMiddleware;
use Google\Auth\OAuth2;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class GoogleShoppingService
{
    protected $client;

    public function __construct()
    {
        // Chemin vers le fichier JSON de clé de service
        $serviceAccountPath = storage_path('app/findyourwatch-bcac971a1ff4.json');

        // Créez un gestionnaire de pile Guzzle avec le middleware d'authentification
        $handlerStack = HandlerStack::create();

        // Créez une fonction qui récupère le jeton d'accès à partir de vos identifiants de compte de service
        $getTokenFunc = function () use ($serviceAccountPath) {
            $auth = new OAuth2([
                'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
                'clientId' => 'YOUR_CLIENT_ID',
                'clientSecret' => 'YOUR_CLIENT_SECRET',
            ]);
            $accessToken = $auth->fetchAuthToken(new Client(), $serviceAccountPath);
            return $accessToken;
        };

        // Poussez le middleware d'authentification dans le gestionnaire de pile
        $middleware = new ScopedAccessTokenMiddleware($getTokenFunc, ['https://www.googleapis.com/auth/content']);
        $handlerStack->push($middleware);

        // Créez un client Guzzle avec le gestionnaire de pile configuré
        $client = new Client([
            'handler' => $handlerStack,
        ]);
    }

    public function fetchProducts($accessToken)
    {

        dump('$accessToken', $accessToken);
        die();
        try {
            $response = $this->client->get('products', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            }

            // Handle other HTTP status codes here.
        } catch (\Exception $e) {
            // Handle exceptions here.
        }

        return null;
    }
}

