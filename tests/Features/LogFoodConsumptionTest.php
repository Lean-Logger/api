<?php

class LogFoodConsumptionTest extends ApiTestCase
{
    /** @var TestFoodData */
    private $foodData;

    public function setUp(): void
    {
        parent::setUp();

        $this->foodData = app(TestFoodData::class);
    }

    public function testNewFoodCanBeLoggedWithMinimalInformation()
    {
        $data = [
            'name' => TestFoodData::FOOD_NAME,
        ];

        $response = $this->json('POST', route('log-food-consumption'), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN]);
        $response->seeStatusCode(201);

        $foodId = json_decode($response->response->getContent(), true)['food_id'];

        $response->seeInDatabase('foods', [
            'name' => TestFoodData::FOOD_NAME,
            'user_id' => $this->jax->getId(),
        ]);

        $response->seeInDatabase('food_logs', [
            'user_id' => $this->jax->getId(),
            'food_id' => $foodId,
        ]);
    }

    public function testNewFoodCanBeLoggedWithAllInformation()
    {
        $data = [
            'name' => TestFoodData::FOOD_NAME,
            'date_time' => '2020-12-20 20:20:20',
        ];

        $response = $this->json('POST', route('log-food-consumption'), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN]);
        $response->seeStatusCode(201);

        $foodId = json_decode($response->response->getContent(), true)['food_id'];

        $response->seeInDatabase('foods', [
            'name' => TestFoodData::FOOD_NAME,
            'user_id' => $this->jax->getId(),
        ]);

        $response->seeInDatabase('food_logs', [
            'user_id' => $this->jax->getId(),
            'food_id' => $foodId,
            'date_time' => '2020-12-20 20:20:20',
        ]);
    }

    public function testExistingFoodForUserIsntRecreated()
    {
        $food = $this->foodData->createIntenseParmesano($this->jax);

        $data = [
            'name' => TestFoodData::FOOD_NAME,
        ];

        $response = $this->json('POST', route('log-food-consumption'), $data, [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN]);
        $response->seeStatusCode(201);

        $response->seeInDatabase('foods', [
            'name' => TestFoodData::FOOD_NAME,
            'user_id' => $this->jax->getId(),
        ]);

        $response->seeInDatabase('food_logs', [
            'user_id' => $this->jax->getId(),
            'food_id' => $food->getId(),
        ]);
    }
}