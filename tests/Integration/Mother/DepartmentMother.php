<?php

declare(strict_types=1);

namespace App\Tests\Integration\Mother;

use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

final class DepartmentMother
{
    private const MODULE_URL = '/api/departments';

    public function __construct(private KernelBrowser $client){}

    public function createNewDepartment(string $name, string $extraPayType, float $extraPayValue): array
    {
        $this->client->request(
            Request::METHOD_POST,
            self::MODULE_URL,
            content: json_encode([
                'name' => $name,
                'extra_pay_type' => $extraPayType,
                'extra_pay_value' => $extraPayValue,
            ], JSON_THROW_ON_ERROR)
        );

        return json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getRandomDepartment(): array
    {
        $departments = $this->getAllDepartments();

        return $departments[random_int(0, count($departments) - 1)];
    }

    /**
     * @throws JsonException
     */
    public function getAllDepartments(): array
    {
        $this->client->request(Request::METHOD_GET, '/api/departments');

        return json_decode(
            $this->client->getResponse()->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}