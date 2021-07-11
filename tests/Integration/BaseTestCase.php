<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Tests\Integration\Mother\DepartmentMother;
use App\Tests\Integration\Mother\EmployeeMother;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseTestCase extends WebTestCase
{
    protected function get(string $endpoint, array $query = []): Response
    {
        $client = self::getClient();
        $client->request(Request::METHOD_GET, $endpoint, ['query' => $query]);

        return $client->getResponse();
    }

    protected function post(string $endpoint, array $body = []): Response
    {
        $client = self::getClient();
        $client->request(Request::METHOD_POST, $endpoint, content: json_encode($body));

        return $client->getResponse();
    }

    protected function getDepartmentMother(): DepartmentMother
    {
        return new DepartmentMother(self::getClient());
    }

    protected function getEmployeeMother(): EmployeeMother
    {
        return new EmployeeMother(self::getClient());
    }

    private static function getClient(): KernelBrowser
    {
        return self::$booted
            ? self::$kernel->getContainer()->get('test.client')
            : self::createClient();
    }
}