<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class LogoutUserTest extends TestCase
{
    use DatabaseTransactions;

    /** @var TestUserData  */
    private $userData;

    /** @var TestLoginTokenData */
    private $loginTokenData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = app(TestUserData::class);
        $this->loginTokenData = app(TestLoginTokenData::class);
    }

    public function testLogoutUser()
    {
        $jax = $this->userData->createUserJax();
        $this->loginTokenData->createLoginTokenForUser($jax);

        $this->json('POST', route('logout-user'), ['user_id' => $jax->getId()])
            ->seeStatusCode(200)
        ;
    }

    public function testLogoutUserWithInvalidId()
    {
        $this->json('POST', route('logout-user'), ['user_id' => TestUserData::NON_EXISTENT_USER_ID])
            ->seeStatusCode(404)
        ;
    }
}