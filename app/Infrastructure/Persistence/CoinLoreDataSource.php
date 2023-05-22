<?php

namespace App\Infrastructure\Persistence;

use App\Application\DataSource\CoinDataSource;
use App\Domain\Coin;

class CoinLoreDataSource implements CoinDataSource
{
    private const BASE_URL = 'https://api.coinlore.net/api';
    public function getCoinByName(string $coin_id, float $amount_usd): ?Coin
    {
        $url = self::BASE_URL . "/tickers/";
        $response = $this->makeRequest($url);
        $response = $response['data'];
        if (!empty($response)) {
            foreach ($response as $coinData) {
                if ($coinData['name'] === $coin_id) {
                    return new Coin(
                        $coinData['id'],
                        $coinData['symbol'],
                        $coinData['name'],
                        $coinData['price_usd'],
                        $amount_usd /  $coinData['price_usd']

                    );
                }
            }
        }

        return null;
    }


    public function getActualValue(string $coin_id): ?float{
        $url = self::BASE_URL . "/tickers/";
        $response = $this->makeRequest($url);
        $response = $response['data'];
        if (!empty($response)) {
            foreach ($response as $coinData) {
                if ($coinData['name'] === $coin_id) {
                    return $coinData['price_usd'];
                }
            }
        }
        return null;

    }


    private function makeRequest(string $url): array
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if ($response === false) {
            throw new RuntimeException("Error al realizar la solicitud a la API: " . curl_error($curl));
        }

        curl_close($curl);

        $responseData = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Error al decodificar la respuesta de la API");
        }

        return $responseData;
    }
}
