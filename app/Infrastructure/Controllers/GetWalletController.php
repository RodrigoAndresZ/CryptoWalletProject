<?php

namespace App\Infrastructure\Controllers;

use App\Application\WalletDataSource\WalletRepository;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetWalletController extends BaseController
{

    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(string $wallet_id): JsonResponse
    {
        //Buscamos la wallet, si no se encuentra devolvemos null
        $wallet = $this->walletRepository->findWalletById($wallet_id);
        if (is_null($wallet)) {
            return response()->json([
                'error' => 'cartera no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }


        //si se encuentra la wallet devolvemos todos sus datos
        return response()->json([
            'user_id' => $wallet->getUserId(),
            'wallet_id' => $wallet->getWalletId(),

            'coins' => $wallet->getCoins()

        ], Response::HTTP_OK);
    }
}
