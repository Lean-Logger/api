<?php

use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ResetPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /** @var TestUserData  */
    private $userData;

    /** @var TestPasswordResetRequestData */
    private $passwordResetRequestData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = app(TestUserData::class);
        $this->passwordResetRequestData = app(TestPasswordResetRequestData::class);
    }

    public function testResetPasswordRequest()
    {
        $jax = $this->userData->createUserJax();
        $this->passwordResetRequestData->createPasswordResetRequest($jax->getEmail(), 123456);

        $payload = [
            'code' => 123456,
            'password' => 'johntellerlives',
            'email' => TestUserData::VALID_EMAIL_ADDRESS_JAX,
        ];

        $this->json('POST', route('reset-password'), $payload)
            ->seeStatusCode(200)
        ;
    }

    public function testResetPasswordFailsWithExpiredCode()
    {
        $jax = $this->userData->createUserJax();
        $this->passwordResetRequestData->createPasswordResetRequest($jax->getEmail(), 123456, (new Carbon())->subHour());

        $payload = [
            'code' => 123456,
            'password' => 'johntellerlives',
            'email' => TestUserData::VALID_EMAIL_ADDRESS_JAX,
        ];

        $this->json('POST', route('reset-password'), $payload)
            ->seeStatusCode(404)
        ;
    }

    public function testResetPasswordFailsWithNonExistentCode()
    {
        $payload = [
            'code' => 123456,
            'password' => 'johntellerlives',
            'email' => TestUserData::VALID_EMAIL_ADDRESS_JAX,
        ];

        $this->json('POST', route('reset-password'), $payload)
            ->seeStatusCode(404)
        ;
    }

    public function testResetPasswordFailsWhenEmailDoesntMatchCode()
    {
        $jax = $this->userData->createUserJax();
        $this->passwordResetRequestData->createPasswordResetRequest($jax->getEmail(), 123456);

        $payload = [
            'code' => 654321,
            'password' => 'johntellerlives',
            'email' => TestUserData::VALID_EMAIL_ADDRESS_JAX,
        ];

        $this->json('POST', route('reset-password'), $payload)
            ->seeStatusCode(404)
        ;
    }
}