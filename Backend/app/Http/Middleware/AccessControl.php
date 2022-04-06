<?php

namespace MovehqApp\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessControl
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* @var Response $response */
        $response = $next($request);

        if (config('whoop.accessControl')) {
            if ($request->method() == 'OPTIONS') {
                $response->headers->add([
                    'Access-Control-Allow-Origin'  => '*',
                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, OPTIONS, DELETE',
                    'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization',
                    'Access-Control-Max-Age'       => '1728000'
                ]);
            } else {
                $response->headers->add([
                    'Access-Control-Allow-Origin'  => '*',
                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, OPTIONS, DELETE',
                    'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization',
                ]);
            }
        }

        return $response;

    }
}
