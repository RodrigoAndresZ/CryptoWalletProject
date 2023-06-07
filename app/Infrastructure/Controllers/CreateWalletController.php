<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateUserService;
use App\Application\CreateWalletService;
//use App\Application\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class CreateWalletController extends BaseController
{
    private CreateWalletService $createWalletService;
    private CreateUserService $createUserService;

    public function __construct(CreateWalletService $createWalletService, CreateUserService $createUserService)
    {
        $this->createWalletService = $createWalletService;
        $this->createUserService = $createUserService;
    }

    public function __invoke(CreateWalletFormRequest $request): JsonResponse
    {
        $jsonData = $request->json()->all();

        $user_id = $jsonData['user_id'];

        $user = $this->createUserService->executeUser($user_id);
        if (is_null($user)) {
            return response()->json([
                'error' => 'usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
        $walletId = $this->createWalletService->executeCreateWallet();
        if ($walletId) {
            return response()->json([
                'exito' => 'wallet creada correctamente',
                'wallet_id' => $walletId
            ], Response::HTTP_OK);
        }
        return response()->json([
            'error' => 'error creacion wallet',
        ], Response::HTTP_NOT_FOUND);
    }
}
