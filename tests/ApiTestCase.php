<?php

use App\Http\Middleware\LoginTokenMiddleware;
use Laravel\Lumen\Testing\DatabaseTransactions;

abstract class ApiTestCase extends TestCase
{
    use DatabaseTransactions;

    /** @var \App\Domain\User\User */
    protected $jax;

    protected const JAX_LOGIN_TOKEN = 'testtoken';

    protected const AUTH_HEADER_NAME = LoginTokenMiddleware::AUTH_HEADER_NAME;

    public function setUp(): void
    {
        parent::setUp();

        /** @var TestUserData $userData */
        $userData = app(TestUserData::class);

        /** @var TestLoginTokenData $loginTokenData */
        $loginTokenData = app(TestLoginTokenData::class);

        $this->jax = $userData->createUserJax();
        $loginTokenData->createLoginTokenForUser($this->jax, self::JAX_LOGIN_TOKEN);
    }
}
