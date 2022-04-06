<?php

namespace MovehqApp\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use InvalidArgumentException;

class JwtGuard implements Guard
{
    use GuardHelpers;

    /**
     * The user
     */
    protected $user;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new authentication guard.
     *
     * @param UserProvider $provider
     * @param Request $request
     * @param  string  $key
     * @return void
     */

    protected $company;

    public function __construct(UserProvider $provider, Request $request, $key = 'api_token')
    {
        $this->key = $key;
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        if (is_null($this->user)) {
            $requestToken = $this->getTokenForRequest();

            if (empty($requestToken)) {
                return null;
            }
            try {
                $tokenParser = new JwtTokenParser($requestToken);
                $tokenIsValid = $tokenParser->isValid();

                if (!$tokenIsValid) {
                    return null;
                }

                $this->user = $this->provider->retrieveById($tokenParser->getClaim('sub'));
            } catch (InvalidArgumentException $exception) {
                return null;
            }
        }

        return $this->user;
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->query($this->key);

        if (empty($token)) {
            $token = $this->request->input($this->key);
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['id'])) {
            return false;
        }

        if ($this->provider->retrieveById($credentials['id'])) {
            return true;
        }

        return false;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function attempt(array $credentials = [])
    {
        if ($user = $this->provider->retrieveByCredentials($credentials)) {
            $this->setUser($user);

            return $user;
        }

        return false;
    }

    public function logout()
    {
        $this->user = null;
    }
}
