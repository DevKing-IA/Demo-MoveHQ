<?php

namespace MovehqAppTests\Controllers\Api\Auth;

use MovehqAppTests\TestCase;
use Illuminate\Support\Facades\Hash;
use MovehqApp\Auth\JwtTokenParser;

class LoginTest extends TestCase
{
    public function testValidLogin()
    {
        $user = $this->createUser();
        $password = 'test1234';

        $user->password = Hash::make($password);
        $user->save();

        $response = $this->postJson('/api/auth/login', [
            'email'         => $user->email,
            'password'      => $password,
        ]);

        $response->assertStatus(200);

        $this->assertIsArray($response->json('user'));
        $this->assertIsBool($response->json('success'));

        // Validate JWT token
        $token = $response->json('token');
        $tokenParser = new JwtTokenParser($token);
        $tokenIsValid = $tokenParser->isValid();
        $sub = $tokenParser->getClaim('sub');

        // dd($response->json('user'));

        $this->assertEquals($sub, $user->id);
        $this->assertTrue($tokenIsValid);
    }
}
