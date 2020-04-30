<?php

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class TestUserData
{
    public const NON_EXISTENT_USER_ID = 9923;

    public const NON_EXISTENT_EMAIL_ADDRESS = 'juice@soa.com';

    public const VALID_EMAIL_ADDRESS_JAX = 'jax@soa.com';

    public const VALID_EMAIL_ADDRESS_CHIBS = 'chibs@soa.com';

    public const INVALID_EMAIL_ADDRESS = 'opie[at]soa.com';

    public const VALID_PASSWORD = 'itwasgemma';

    public const OPT_IN_TRUE = 1;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUserJax(): User
    {
        return $this->userRepository->register(
            self::VALID_EMAIL_ADDRESS_JAX,
            Hash::make(self::VALID_PASSWORD),
            self::OPT_IN_TRUE
        );
    }
}