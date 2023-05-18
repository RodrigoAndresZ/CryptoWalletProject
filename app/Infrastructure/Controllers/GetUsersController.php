<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use App\Application\UserDataSource\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetUsersController extends BaseController
{
    private UserRepository $userDataSource;

    public function __construct(UserRepository $userDataSource, UserRepository $localUserDataSource)
    {
        $this->userDataSource = $userDataSource;
    }


    public function __invoke(): JsonResponse
    {
        $user = $this->userDataSource->getAll();
        if ($user == []) {
            return response()->json([
            ], Response::HTTP_OK);
        }
        return response()->json([
            [
                'id' => '1',
                'email' => 'email@email.com',
            ],[
                'id' => '2',
                'email' => 'another_email@email.com',
            ]], Response::HTTP_OK);
    }
}
