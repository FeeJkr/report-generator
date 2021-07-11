<?php

declare(strict_types=1);

namespace App\Tests\Integration\Employee;

use App\Tests\Integration\BaseTestCase;
use DateInterval;
use DateTime;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final class CreateNewEmployeeTest extends BaseTestCase
{
    private const ENDPOINT = '/api/employees';

    /**
     * @test
     */
    public function shouldCreateNewEmployee(): void
    {
        $faker = Factory::create();
        $this->getDepartmentMother()->createNewDepartment($faker->firstName(), 'const', $faker->randomFloat(max: 100));

        $response = $this->post(self::ENDPOINT, [
            'department_id' => $this->getDepartmentMother()->getRandomDepartment()['id'],
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'salary' => $faker->randomFloat(max: 10000),
            'employed_at' => $faker->date(),
        ]);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnErrorWithInvalidEmployedAtDate(): void
    {
        $faker = Factory::create();
        $this->getDepartmentMother()->createNewDepartment($faker->firstName(), 'const', $faker->randomFloat(max: 100));

        $response = $this->post(self::ENDPOINT, [
            'department_id' => $this->getDepartmentMother()->getRandomDepartment()['id'],
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'salary' => $faker->randomFloat(max: 10000),
            'employed_at' => (new DateTime)->add(new DateInterval('P3D'))->format('Y-m-d'),
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
    public function shouldReturnErrorWithNotFoundDepartment(): void
    {
        $faker = Factory::create();

        $response = $this->post(self::ENDPOINT, [
            'department_id' => Uuid::uuid4()->toString(),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'salary' => $faker->randomFloat(max: 10000),
            'employed_at' => (new DateTime)->add(new DateInterval('P3D'))->format('Y-m-d'),
        ]);

        self::assertEquals(Response::HTTP_CONFLICT, $response->getStatusCode());
    }
}