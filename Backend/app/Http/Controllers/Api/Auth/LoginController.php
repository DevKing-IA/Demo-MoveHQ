<?php

namespace MovehqApp\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends AbstractController
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return Response|RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user = Auth::user();

        return $this->userData($request, $user, null);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return [
            'error' => trans('auth.failed')
        ];
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     * @return mixed
     */
    protected function loggedOut()
    {
        return [
            'success' => true,
            'message' => 'Logged out'
        ];
    }

    public function logout(Request $request)
    {
        auth('jwt')->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
