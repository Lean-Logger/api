<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginUserTest extends TestCase
{
    use DatabaseTransactions;

    /** @var TestUserData  */
    private $userData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = app(TestUserData::class);
    }

    public function testUserCanLoginAndGetUserToken()
    {
        $jax = $this->userData->createUserJax();

        $this->json('POST', route('login-user'), ['email' => $jax->getEmail(), 'password' => TestUserData::VALID_PASSWORD])
            ->seeJsonStructure(['login_token'])
            ->seeStatusCode(201)
        ;
    }

    public function testUserCantLoginWithInvalidPassword()
    {
        $jax = $this->userData->createUserJax();

        $this->json('POST', route('login-user'), ['email' => $jax->getEmail(), 'password' => 'therealira'])
            ->seeStatusCode(404)
        ;
    }

    public function testUserCantLoginWithInvalidUser()
    {
        $this->json('POST', route('login-user'), ['email' => 'clay@soa.com', 'password' => TestUserData::VALID_PASSWORD])
            ->seeStatusCode(404)
        ;
    }
}