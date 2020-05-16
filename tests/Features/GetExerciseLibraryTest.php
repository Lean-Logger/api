<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class GetExerciseLibraryTest extends ApiTestCase
{
    use DatabaseTransactions;

    /** @var TestExerciseData */
    private $exerciseData;

    public function setUp(): void
    {
        parent::setUp();

        $this->exerciseData = app(TestExerciseData::class);
    }

    public function testExerciseLibraryCanBePulled()
    {
        $this->exerciseData->createBicepCurlExerciseForUser($this->jax);
        $this->exerciseData->createBicepCurlExerciseForUser($this->jax);
        $this->exerciseData->createBicepCurlExerciseForUser($this->jax);

        $this->json('GET', route('get-exercise-library'), [], [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->assertResponseOk()
        ;

        $data = json_decode($this->response->getContent());

        $this->assertCount(3, $data->items);
    }
}