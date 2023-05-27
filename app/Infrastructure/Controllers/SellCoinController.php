<?php

namespace App\Infrastructure\Controllers;

use App\Application\SellCoinService;
use App\Application\CreateWalletService;
use App\Infrastructure\Persistence\ApiCoinDataSource\ApiCoinRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class SellCoinController extends BaseController
{
    private SellCoinService $sellCoinService;
    private CreateWalletService $createWalletService;




    public function __construct(SellCoinService $sellCoinService, CreateWalletService $createWalletService)
    {
        $this->sellCoinService = $sellCoinService;
        $this->createWalletService = $createWalletService;
    }


    public function __invoke(BuyCoinFormRequest $request): JsonResponse
    {
        $jsonData = $request->json()->all();

        $coinId = $jsonData['coin_id'];
        $wallet_id = $jsonData['wallet_id'];
        $amountUsd = $jsonData['amount_usd'];

        $coin = $this->sellCoinService->execute($coinId, $amountUsd);

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

        $this->createWalletService->executeSellCoinWallet(
            $wallet->getWalletId(),
            $coin,
            $this->sellCoinService->executeActualPrice($coinId),
            $amountUsd
        );
        return response()->json([
            'exito' => 'moneda vendida correctamente',
        ], Response::HTTP_OK);
    }
}
