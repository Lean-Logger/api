<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class RequestPasswordResetTest extends TestCase
{
    use DatabaseTransactions;

    /** @var TestUserData  */
    private $userData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = app(TestUserData::class);
    }

    public function testResetPassword()
    {
        $jax = $this->userData->createUserJax();

        $this->json('POST', route('request-password-reset'), ['email' => $jax->getEmail()])
            ->seeStatusCode(201)
        ;
    }

    public function testResetPasswordRequestWithNonExistentEmail()
    {
        $this->json('POST', route('request-password-reset'), ['email' => TestUserData::NON_EXISTENT_EMAIL_ADDRESS])
            ->seeStatusCode(201)
        ;
    }

    public function testResetPasswordRequestWithInvalidEmail()
    {
        $this->json('POST', route('request-password-reset'), ['email' => TestUserData::INVALID_EMAIL_ADDRESS])
            ->seeStatusCode(422)
        ;
    }
}