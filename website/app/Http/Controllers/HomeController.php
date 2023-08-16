<?php

namespace App\Http\Controllers;

use GuzzleHttp;

class HomeController extends Controller
{

    public function show()
    {
        $this->getProductData();
        return view('text');
    }

    public function getProductData()
    {

        // Remplacez 'YOUR_RAKUTEN_API_KEY' par votre clé d'API Rakuten
        $apiToken = config('app.rakutenApiToken');

        // URL de l'API Rakuten
        $apiUrl = "https://api.rakutenadvertising.com/products/1.0?keyword=watches&cat=jewelry&language=fr_FR&max=20&pagenumber=1&mid=50221&sort=productname&sorttype=asc";

        // Paramètres de la requête
        $queryParams = [
            'apiKey' => $apiToken,
            'query' => 'watches', // Votre requête de recherche ici
        ];

        $response = $client->request('POST', $url, [
            'body' => $this->buildBody($fields),
            'headers' => [
                'x-api-key' => config('other.etx_api_key'),
            ]
        ]);


        // Faire une requête HTTP à l'API Rakuten
        try {
            $client = new GuzzleHttp\Client();
            $request = $client->request(
                'GET',
                $apiUrl,
                ['verify' => false]
            );
            $result = json_decode($request->getBody());
        } catch(\Exception $e) {
            $this->info('Error: Token expired. Sign in to Instagram from the admin interface');
            exit;
        }

        try {
            $response = $client->get($apiUrl, [
                'query' => $queryParams,
            ]);

            dump('$response', $response->status());
            dump('$response', $response->body());
            die();

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return "Erreur de requête : " . $e->getMessage();
        }

    }
}
