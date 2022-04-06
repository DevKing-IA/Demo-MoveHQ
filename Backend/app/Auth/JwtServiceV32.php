<?php

namespace MovehqApp\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

/**
 * Note this service requires lcobucci/jwt:3.2
 */

class JwtServiceV32
{
    /**
     * @param Request $request
     * @param User $user
     * @param $minutes
     * @param $additionalData
     * @return string
     */
    public static function generateToken($request, $user, $minutes = null, $additionalData = [])
    {
        return self::generateTokenForHost($request->getHost(), $user, $minutes, $additionalData);
    }

    /**
     * @param string $host
     * @param User $user
     * @param $minutes
     * @param $additionalData
     * @return string
     */
    public static function generateTokenForHost($host, $user, $minutes = null, $additionalData = [])
    {
        $signer = new Sha256();
        $signerKey = new Key(config('app.key'));

        $builder = (new Builder())
            ->setIssuer($host) // Configures the issuer (iss claim)
            ->setAudience($host) // Configures the audience (aud claim)
            ->setSubject($user->id) // Configures the audience (aud claim)
            ->setId(Str::random(), true) // Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
        ;

        $builder->set('com', 0);

        if ($minutes) {
            $builder->setExpiration(time() + ($minutes * 60));
        }

        $builder->sign($signer, $signerKey);

        return $builder->getToken()->__toString();
    }

    public static function validate($requestToken)
    {
        $parser = new Parser();
        $token = $parser->parse($requestToken);
    }
}
