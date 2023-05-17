<?php

namespace App\Infrastructure\Persistence;

use App\Application\CreateWalletService;

class CreateWalletController
{
    /*
    private CreateWalletService $walletService;

    public function __construct(CreateWalletService $walletService, CreateWalletService  $localCreateWalletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(CreateWalletService $walletService: JsonResponse
    {
        $user = $this->userDataSource->findByEmail($userEmail);
        if (is_null($user)){
            return response()->json([
                'error' => 'usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'id' => $user->getId(),
            'email' => $user->getEmail()
        ], Response::HTTP_OK);
    }
    */
}
