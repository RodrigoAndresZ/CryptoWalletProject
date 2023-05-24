<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;
use App\Infrastructure\Persistence\ApiCoinDataSource\ApiCoinRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class BuyCoinController extends BaseController
{
    private UserRepository $userDataSource;

    private WalletRepository $walletRepository;
    private BuyCoinService $buyCoinService;

    private ApiCoinRepository $apiCoinRepository;


    public function __construct(BuyCoinService $buyCoinService)
    {
        $this->buyCoinService = $buyCoinService;
    }

    //Le pasamos BuyCoinFormRequest
    public function __invoke(string $coin_id, string $wallet_id): JsonResponse
    {
        //Buscamos la wallet, si no se encuentra devolvemos null
        $wallet = $this->walletRepository->findWalletById($wallet_id);
        if (is_null($wallet)) {
            return response()->json([
                'error' => 'cartera no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $coin = $this->apiCoinRepository->getById($coin_id);
        if (is_null($coin)) {
            return response()->json([
                'error' => 'moneda no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        //si se encuentra la wallet devolvemos todos sus datos
        return response()->json([
             //'user_id' => $wallet->getUserId(),
             'wallet_id' => $wallet->getWalletId(),
             'coin_id' => $wallet->getCoinId(),
             'name' => $wallet->getName(),
             'symbol' => $wallet->getSymbol(),
             'amount' => $wallet->getAmount(),
             'value_usd' => $wallet->getValueUsd(),
             'balance_usd' => $wallet->getBalanceUsd()
        ], Response::HTTP_OK);
    }
}
