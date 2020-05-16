<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class EditExerciseTest extends ApiTestCase
{
    use DatabaseTransactions;

    /** @var TestExerciseData */
    private $exerciseData;

    public function setUp(): void
    {
        parent::setUp();

        $this->exerciseData = app(TestExerciseData::class);
    }

    public function testExistingExerciseCanBeUpdated()
    {
        $exercise = $this->exerciseData->createBicepCurlExerciseForUser($this->jax);

        $data = [
            'name' => 'New Bicep Curls',
            'type' => TestExerciseData::TYPE_WEIGHTED_REPS,
        ];

        $this->json('PUT', route('edit-exercise', ['id' => $exercise->getId()]), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->seeStatusCode(200)
        ;
    }

    public function testNonExistentExerciseIsHandled()
    {
        $data = [
            'name' => 'New Bicep Curls',
            'type' => TestExerciseData::TYPE_WEIGHTED_REPS,
        ];

        $this->json('PUT', route('edit-exercise', ['id' => 123]), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->seeJsonStructure([
                'error'
            ])
            ->seeStatusCode(404)
        ;
    }
}