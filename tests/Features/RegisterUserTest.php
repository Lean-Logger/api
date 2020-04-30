<?php

use App\Domain\User\UserRepositoryInterface;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegisterUserTest extends TestCase
{
    use DatabaseTransactions;

    private const VALID_EMAIL_ADDRESS_JAX = 'jax@soa.com';

    private const VALID_EMAIL_ADDRESS_CHIBS = 'chibs@soa.com';

    private const INVALID_EMAIL_ADDRESS = 'opie[at]soa.com';

    private const VALID_PASSWORD = 'itwasgemma';

    private const OPT_IN_TRUE = 1;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = app(UserRepositoryInterface::class);
    }

    public function testNewUserCanBeSuccessfullyRegistered()
    {
        $data = [
            'email' => self::VALID_EMAIL_ADDRESS_JAX,
            'password' => self::VALID_PASSWORD,
            'opt_in' => 1,
        ];

        $this->json('POST', route('register-user'), $data)
            ->seeJson([
                'email' => 'jax@soa.com',
            ])
            ->seeStatusCode(201)
        ;
    }

    public function testNewUserIsntCreatedWithInvalidData()
    {
        $data = [
            'email' => self::INVALID_EMAIL_ADDRESS,
            'password' => self::VALID_PASSWORD,
        ];

        $this->json('POST', route('register-user'), $data)
            ->seeJsonStructure([
                'errors' => ['email', 'opt_in']
            ])
            ->seeStatusCode(422)
        ;
    }

    public function testNewUserIsntCreatedWithDuplicateEmailAddress()
    {
        $this->userRepository->register(
            self::VALID_EMAIL_ADDRESS_JAX,
            self::VALID_PASSWORD,
            self::OPT_IN_TRUE
        );

        $data = [
            'email' => self::VALID_EMAIL_ADDRESS_JAX,
            'password' => self::VALID_PASSWORD,
            'opt_in' => self::OPT_IN_TRUE,
        ];

        $this->json('POST', route('register-user'), $data)
            ->seeJson(['errors' => ['email' => ['The email has already been taken.']]])
            ->seeStatusCode(422)
        ;
    }
}