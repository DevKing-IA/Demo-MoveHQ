<?php

namespace MovehqApp\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;

class PingController extends AbstractController
{
    /**
     * Return current token
     *
     * @param Request $request
     * @return array
     */
    protected function ping(Request $request)
    {
        $user = $this->user();

        if ($user) {
            return $this->userData($request, $user);
        } else {
            return [
                'success' => false,
                'message' => 'Not authenticated',
            ];
        }
    }
}
