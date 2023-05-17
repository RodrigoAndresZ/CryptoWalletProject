<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserRepository;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetEarlyAdopterController extends BaseController
{
    private UserRepository $userDataSource;

    public function __construct(UserRepository $userDataSource, UserRepository $localUserDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    public function __invoke(string $userEmail): JsonResponse
    {
        $user = $this->userDataSource->findByEmail($userEmail);
        if (is_null($user)) {
            return response()->json([
                'error' => 'usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }
        if ($user->getUserId() < 1000) {
            return response()->json([
                'El usuario es early adopter'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'El usuario no es early adopter'
        ], Response::HTTP_OK);
    }
}
