<?php

namespace App\Infrastructure\Controllers;

use App\Application\DataSource\CoinDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use App\Infrastructure\Persistence\CoinLoreDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Domain\Coin;
use App\Infrastructure\Controllers\BuyCoinFormRequest;
use App\Infrastructure\Service\BuyCoinService;

class BuyCoinController extends BaseController
{
    private BuyCoinService $buyCoinService;

    /**
     * @param BuyCoinService $buyCoinService
     */
    public function __construct(BuyCoinService $buyCoinService)
    {
        $this->buyCoinService = $buyCoinService;
    }


    public function __invoke(BuyCoinFormRequest $request): JsonResponse
    {
        $jsonData = $request->json()->all();

        $coinId = $jsonData['coin_id'];
        $walletId = $jsonData['wallet_id'];
        $amountUsd = $jsonData['amount_usd'];

        $coin = $this->buyCoinService->execute($coinId,$amountUsd);


        if ($coin === null) {
            return response()->json([
                'error' => 'El coin id dado no existe'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'coin_id' => $coin->getCoinId(),
            'name' => $coin->getName(),
            'symbol' => $coin->getSymbol(),
        ], Response::HTTP_OK);



        /*// Calcula la cantidad de moneda que se puede comprar
        $coinPrice = $coin->getValueUsd();
        $coinAmount = $amountUsd / $coinPrice;

        // Obtiene la wallet desde la caché
        $wallet = Cache::get('wallet:' . $wallet_id);

        if ($wallet === null) {
            return response()->json(['error' => 'La wallet no existe'], Response::HTTP_NOT_FOUND);
        }

        $coins = $wallet['coins'];
        $coins[$coinId] = $coin->toArray(); // Agrega todos los datos de la moneda al array
        $coins[$coinId]['amount'] = $coinAmount; // Agrega la cantidad de moneda comprada
        $wallet['coins'] = $coins;

        Cache::put('wallet:' . $wallet_id, $wallet);

        return response()->json([
            'coin_id' => $coin->getCoinId(),
            'name' => $coin->getName(),
            'symbol' => $coin->getSymbol(),
            'coin_amount' => $coinAmount,
        ], Response::HTTP_OK);*/
    }
}
