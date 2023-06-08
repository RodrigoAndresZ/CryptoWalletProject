<?php

namespace App\Infrastructure\Controllers;

use App\Application\DataSource\WalletDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;


class GetWalletController extends BaseController
{
    private WalletDataSource $walletRepository;

    public function __construct(WalletDataSource $walletRepository)
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

        $wallet = $this->walletRepository->getWalletById($wallet_id);
        //si se encuentra la wallet devolvemos todos sus datos
        return response()->json($wallet['coins'], Response::HTTP_OK);
    }
}
