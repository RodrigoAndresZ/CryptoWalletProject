<?php

namespace App\Infrastructure\Controllers;

use App\Application\DataSource\WalletDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class GetWalletController extends BaseController
{
    private WalletDataSource $walletRepository;
    private CacheRepository $cache;

    public function __construct(WalletDataSource $walletRepository, CacheRepository $cache)
    {
        $this->walletRepository = $walletRepository;
        $this->cache = $cache;
    }

    public function __invoke(string $wallet_id): JsonResponse
    {
        // Buscamos la wallet, si no se encuentra devolvemos null
        $wallet = $this->walletRepository->findWalletById($wallet_id);
        if (is_null($wallet)) {
            return response()->json([
                'error' => 'cartera no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $wallet = $this->cache->get('wallet_' . $wallet_id);

        // Si se encuentra la wallet, devolvemos todos sus datos
        return response()->json($wallet['coins'], Response::HTTP_OK);
    }
}
