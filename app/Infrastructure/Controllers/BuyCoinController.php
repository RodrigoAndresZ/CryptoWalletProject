<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateWalletService;
use App\Infrastructure\Persistence\ApiCoinDataSource\ApiCoinRepository;
use App\Infrastructure\Service\BuyCoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class BuyCoinController extends BaseController
{
    private BuyCoinService $buyCoinService;
    private CreateWalletService $createWalletService;




    public function __construct(BuyCoinService $buyCoinService, CreateWalletService $createWalletService)
    {
        $this->buyCoinService = $buyCoinService;
        $this->createWalletService = $createWalletService;
    }


    public function __invoke(BuyCoinFormRequest $request): JsonResponse
    {
        $jsonData = $request->json()->all();

        $coinId = $jsonData['coin_id'];
        $wallet_id = $jsonData['wallet_id'];
        $amountUsd = $jsonData['amount_usd'];

        $coin = $this->buyCoinService->execute($coinId, $amountUsd);

        if ($coin === null) {
            return response()->json([
                'error' => 'El coin id dado no existe'
            ], Response::HTTP_NOT_FOUND);
        }

        $wallet = $this->createWalletService->executefindWalletById($wallet_id);
        if (is_null($wallet)) {
            return response()->json([
                'error' => 'Wallet con ese ID no fue encontrada'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->createWalletService->executeAddCoinInWallet($wallet->getWalletId(), $coin);
        return response()->json([
            'exito' => 'moneda comprada correctamente'
        ], Response::HTTP_OK);
    }
}
