<?php

namespace App\Infrastructure\Controllers;

use App\Application\DataSource\CoinDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use App\Infrastructure\Persistence\CoinLoreDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Domain\Coin;

class BuyCoinController extends BaseController
{
    private CoinDataSource $coinDataSource;

    /**
     * @param CoinDataSource $coinDataSource
     */
    public function __construct(CoinDataSource $coinDataSource)
    {
        $this->coinDataSource = $coinDataSource;
    }


    public function __invoke(Request $request): JsonResponse
    {



        $coinId = $request->input('id');
        $walletId = $request->input('id2');
        $amountUsd = $request->input('amount_usd');

        $coin = $this->coinDataSource->getCoinByName($coinId);


        if ($coin === null) {
            return response()->json(['error' => 'La coin no existe'], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'coin_id' => $coin->getCoinId(),
            'name' => $coin->getName(),
            'symbol' => $coin->getSymbol(),
        ], Response::HTTP_OK);

        // Resto de la lógica para comprar la moneda
    }
}
