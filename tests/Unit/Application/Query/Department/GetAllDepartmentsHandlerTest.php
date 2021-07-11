<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\Department;

use App\Application\Query\Department\DepartmentReadModel;
use App\Application\Query\Department\GetAllDepartmentsHandler;
use App\Application\Query\Department\ViewModel\Department;
use App\Application\Query\Department\ViewModel\DepartmentsCollection;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class GetAllDepartmentsHandlerTest extends TestCase
{
    private DepartmentReadModel|MockObject $departmentReadModelMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->departmentReadModelMock = $this->createMock(DepartmentReadModel::class);
    }

    /**
     * @test
     */
    public function shouldReturnAllDataSet(): void
    {
        $expectedData = new DepartmentsCollection(
            new Department(Uuid::uuid4()->toString(), 'Testing', 'const', 1234),
            new Department(Uuid::uuid4()->toString(), 'Testing2', 'const', 1234),
            new Department(Uuid::uuid4()->toString(), 'Testing3', 'const', 1234),
            new Department(Uuid::uuid4()->toString(), 'Testing4', 'const', 1234),
        );

        $this->departmentReadModelMock->expects(self::once())->method('getAllDepartments')->willReturn($expectedData);

        $result = $this->getSut()->handle();

        self::assertEquals($expectedData, $result);
    }

    #[Pure] private function getSut(): GetAllDepartmentsHandler
    {
        return new GetAllDepartmentsHandler(
            $this->departmentReadModelMock
        );
    }
}