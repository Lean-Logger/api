<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class GetFoodLogsTest extends ApiTestCase
{
    use DatabaseTransactions;

    /** @var TestFoodData */
    private $foodData;

    /** @var TestFoodLogData */
    private $foodLogData;

    public function setUp(): void
    {
        parent::setUp();

        $this->foodData = app(TestFoodData::class);
        $this->foodLogData = app(TestFoodLogData::class);
    }

    public function testFoodLogsCanBePulled()
    {
        $date = new \DateTime();

        $food = $this->foodData->createIntenseParmesano($this->jax);
        $this->foodLogData->logFoodForUser($food, $this->jax, $date);
        $this->foodLogData->logFoodForUser($food, $this->jax, $date);

        $this->json('GET', route('get-food-log'), ['date' => $date->format('Y-m-d')], [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->assertResponseOk()
        ;

        $data = json_decode($this->response->getContent());

        $this->assertCount(2, $data->items);
    }
}