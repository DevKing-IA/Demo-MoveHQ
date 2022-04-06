<?php

namespace MovehqApp\Auth;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

/**
 * Note this service requires lcobucci/jwt:3.2
 */

class JwtTokenParser
{
    private string $token = '';
    private ?Token $parsedToken = null;

    public function __construct($token, $key = null)
    {
        $this->token = $token;
        $this->key = $key ?? config('app.key');
    }

    public function parse()
    {
        $parser = new Parser();
        $this->parsedToken = $parser->parse($this->token);

        return true;
    }

    public function isValid()
    {
        if (!$this->parsedToken) {
            $this->parse();
        }

        $data = new ValidationData();
        $data->setIssuer($this->parsedToken->getClaim('iss'));
        $data->setAudience($this->parsedToken->getClaim('aud'));
        $data->setSubject($this->parsedToken->getClaim('sub'));

        $verify = $this->parsedToken->verify(new Sha256(),  $this->key);
        $valid = $this->parsedToken->validate($data);

        if (!$verify || !$valid) {
            return false;
        }

        return true;
    }


    public function getClaim(string $claim)
    {
        if (!$this->parsedToken) {
            $this->parse();
        }

        return $this->parsedToken->getClaim($claim);
    }
}
