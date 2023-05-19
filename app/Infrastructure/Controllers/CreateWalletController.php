<?php

namespace App\Infrastructure\Controllers;

use App\Application\CreateWalletService;
use App\Application\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class CreateWalletController extends BaseController
{
    private CreateWalletService $createWalletService;

    public function __construct(CreateWalletService $createWalletService)
    {
        $this->createWalletService = $createWalletService;
    }

    public function __invoke(CreateWalletFormRequest $request): JsonResponse
    {
        $jsonData = $request->json()->all();

        $user_id = $jsonData['user_id'];

        try {
            $wallet = $this->createWalletService->execute("$user_id");
        } catch (UserNotFoundException $userNotFoundExceptio) {
            return response()->json([
                'error' => 'usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'wallet_id' => $wallet
        ], Response::HTTP_OK);
    }
}
