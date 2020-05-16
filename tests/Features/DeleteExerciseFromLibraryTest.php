<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class DeleteExerciseFromLibraryTest extends ApiTestCase
{
    use DatabaseTransactions;

    /** @var TestExerciseData */
    private $exerciseData;

    public function setUp(): void
    {
        parent::setUp();

        $this->exerciseData = app(TestExerciseData::class);
    }

    public function testExerciseCanBeDeleted()
    {
        $exercise = $this->exerciseData->createBicepCurlExerciseForUser($this->jax);

        $this->json('DELETE', route('delete-exercise-from-library', ['id' => $exercise->getId()]), [], [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->seeStatusCode(200)
        ;
    }
}