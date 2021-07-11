<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\Employee;

use App\Application\Query\Employee\EmployeeReadModel;
use App\Application\Query\Employee\GetAllEmployeesHandler;
use App\Application\Query\Employee\ViewModel\Employee;
use App\Application\Query\Employee\ViewModel\EmployeesCollection;
use DateTime;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class GetAllEmployeesHandlerTest extends TestCase
{
    private EmployeeReadModel|MockObject $employeeReadModelMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->employeeReadModelMock = $this->createMock(EmployeeReadModel::class);
    }

    /**
     * @test
     */
    public function shouldReturnAllDataSet(): void
    {
        $expectedData = new EmployeesCollection(
            new Employee(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'HR', 'Testing', 'Test', 1111, (new DateTime)),
            new Employee(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'BOK', 'Testing', 'Test', 2222, (new DateTime)),
            new Employee(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'IT', 'Testing', 'Test', 3333, (new DateTime)),
            new Employee(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'CTO', 'Testing', 'Test', 4444, (new DateTime)),
        );

        $this->employeeReadModelMock->expects(self::once())->method('getAllEmployees')->willReturn($expectedData);

        $result = $this->getSut()->handle();

        self::assertEquals($expectedData, $result);
    }

    #[Pure] private function getSut(): GetAllEmployeesHandler
    {
        return new GetAllEmployeesHandler(
            $this->employeeReadModelMock
        );
    }
}