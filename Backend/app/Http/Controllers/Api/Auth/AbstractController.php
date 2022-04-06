<?php

namespace MovehqApp\Http\Controllers\Api\Auth;

use MovehqApp\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use MovehqApp\Auth\JwtServiceV32;

class AbstractController extends BaseApiController
{
    /**
     * @param Request $request
     * @param $user
     * @return array
     */
    protected function userData($request, $user = null)
    {
        $user = $user ?? $this->user();

        $userData = $user->toArray();

        $oneWeek = 7 * 24 * 60;

        return [
            'token'         => JwtServiceV32::generateToken($request, $user, $oneWeek, []),
            'user'          => $userData,
            'success'       => true
        ];
    }
}
