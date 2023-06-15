<?php

namespace App\Infrastructure\Controllers;

use App\Application\DataSource\CoinDataSource;
use App\Application\DataSource\WalletDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class GetWalletBalanceController extends BaseController
{
    private WalletDataSource $walletRepository;
    private CoinDataSource $coinDataSource;
    private CacheRepository $cache;

    public function __construct(
        WalletDataSource $walletRepository,
        CoinDataSource $coinDataSource,
        CacheRepository $cache
    ) {
        $this->walletRepository = $walletRepository;
        $this->coinDataSource = $coinDataSource;
        $this->cache = $cache;
    }

    public function __invoke(string $wallet_id): JsonResponse
    {
        // Buscamos la wallet, si no se encuentra devolvemos null
        $wallet = $this->walletRepository->findWalletById($wallet_id);
        if (is_null($wallet)) {
            return response()->json([
                'error' => 'cartera no encontrada'
            ], Response::HTTP_NOT_FOUND);
        }

        $balance = 0;

        $walletData = $this->cache->get('wallet_' . $wallet_id);

        foreach ($walletData['coins'] as $coin) {
            $balance += $this->coinDataSource->getActualValue($coin['coin_id']) * $coin['amount'];
        }

        // Si se encuentra la wallet, devolvemos el saldo en USD
        return response()->json([
            "balance_usd" => $balance
        ], Response::HTTP_OK);
    }
}
