<?php

declare(strict_types=1);

namespace App\Tests\Integration\Department;

use App\Tests\Integration\BaseTestCase;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Response;

final class CreateNewDepartmentTest extends BaseTestCase
{
    private const ENDPOINT = '/api/departments';

    /**
     * @test
     */
    public function shouldCreateNewDepartment(): void
    {
        $faker = Factory::create();

        $response = $this->post(self::ENDPOINT, [
            'name' => $faker->name(),
            'extra_pay_type' => 'const',
            'extra_pay_value' => $faker->randomFloat(max: 1250),
        ]);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnErrorWithInvalidExtraPayType(): void
    {
        $faker = Factory::create();

        $response = $this->post(self::ENDPOINT, [
            'name' => $faker->firstName(),
            'extra_pay_type' => $faker->name(),
            'extra_pay_value' => $faker->randomFloat(max: 1250),
        ]);

        self::assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnErrorWithEmptyRequest(): void
    {
        $response = $this->post(self::ENDPOINT, []);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnErrorWithInvalidRequestValues(): void
    {
        $faker = Factory::create();

        $response = $this->post(self::ENDPOINT, [
            'name' => $faker->realTextBetween(400, 500),
            'extra_pay_type' => 'const',
            'extra_pay_value' => $faker->randomFloat(max: 1250),
        ]);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}