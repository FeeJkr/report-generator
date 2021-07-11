<?php

declare(strict_types=1);

namespace App\Tests\Integration\Mother;

use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

final class EmployeeMother
{
    private const MODULE_URL = '/api/employees';

    public function __construct(private KernelBrowser $client){}

    public function createNewEmployee(
        string $departmentId,
        string $firstName,
        string $lastName,
        float $salary,
        DateTimeInterface $employedAt,
    ): array {
        $this->client->request(
            Request::METHOD_POST,
            self::MODULE_URL,
            content: json_encode([
                'department_id' => $departmentId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'salary' => $salary,
                'employed_at' => $employedAt->format('Y-m-d'),
            ], JSON_THROW_ON_ERROR)
        );

        return json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}