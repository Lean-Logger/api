<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AddExerciseToLibraryTest extends ApiTestCase
{
    use DatabaseTransactions;

    public function testNewExerciseCanBeAddedToLibrarySuccessfully()
    {
        $data = [
            'name' => TestExerciseData::EXERCISE_NAME,
            'type' => 'weighted_reps',
        ];

        $this->json('POST', route('add-exercise-to-library'), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->seeStatusCode(201)
        ;
    }

    public function testNewExerciseIsntCreatedWithInvalidData()
    {
        $data = [
            'type' => 'watermelon',
        ];

        $this->json('POST', route('add-exercise-to-library'), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->seeJsonStructure([
                'errors' => ['name', 'type']
            ])
            ->seeStatusCode(422)
        ;
    }
}