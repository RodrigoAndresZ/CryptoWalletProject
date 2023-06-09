<?php

namespace App\Infrastructure\Controllers;

use App\Application\BuyCoinService;
use App\Application\DataSource\CoinDataSource;
use App\Application\DataSource\WalletDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class GetWalletBalanceController extends BaseController
{
    private WalletDataSource $walletRepository;
    private CoinDataSource $coinDataSource;

    public function __construct(WalletDataSource $walletRepository, CoinDataSource $coinDataSource)
    {
        $this->walletRepository = $walletRepository;
        $this->coinDataSource = $coinDataSource;
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
        $balanceActual = 0;
        $balanceCost = 0;

        $wallet = $this->walletRepository->getWalletById($wallet_id);
        foreach ($wallet['coins'] as $coin) {
            $balanceActual += $this->coinDataSource->getActualValue($coin['coin_id']) * $coin['amount'];
            $balanceCost += $coin['value_usd'] * $coin['amount'];
        }

        //si se encuentra la wallet devolvemos todos sus datos
        return response()->json([
            "balance_usd" => $balanceActual - $balanceCost
        ], Response::HTTP_OK);
    }
}
