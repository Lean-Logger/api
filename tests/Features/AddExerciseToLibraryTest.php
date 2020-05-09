<?php

use App\Domain\User\UserRepositoryInterface;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AddExerciseToLibraryTest extends TestCase
{
    use DatabaseTransactions;

    /** @var TestUserData  */
    private $userData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = app(TestUserData::class);
    }

    public function testNewExerciseCanBeAddedToLibrarySuccessfully()
    {
        $jax = $this->userData->createUserJax();

        $data = [
            'user_id' => $jax->getId(),
            'name' => TestExerciseData::EXERCISE_NAME,
            'type' => 'weighted_reps',
        ];

        $this->json('POST', route('add-exercise-to-library'), $data)
            ->seeStatusCode(201)
        ;
    }

    public function testNewExerciseIsntCreatedWithInvalidData()
    {
        $data = [
            'type' => 'watermelon',
        ];

        $this->json('POST', route('add-exercise-to-library'), $data)
            ->seeJsonStructure([
                'errors' => ['user_id', 'name', 'type']
            ])
            ->seeStatusCode(422)
        ;
    }
}