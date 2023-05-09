<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetUsersController extends BaseController
{
    private UserDataSource $userDataSource;

    public function __construct(UserDataSource $userDataSource, UserDataSource $localUserDataSource)
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
