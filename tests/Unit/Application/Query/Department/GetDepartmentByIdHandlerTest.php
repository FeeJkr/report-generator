<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\Department;

use App\Application\Query\Department\DepartmentReadModel;
use App\Application\Query\Department\GetDepartmentByIdHandler;
use App\Application\Query\Department\GetDepartmentByIdQuery;
use App\Application\Query\Department\ViewModel\Department;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class GetDepartmentByIdHandlerTest extends TestCase
{
    private MockObject|DepartmentReadModel $departmentReadModelMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->departmentReadModelMock = $this->createMock(DepartmentReadModel::class);
    }

    /**
     * @test
     */
    public function shouldReturnDepartmentById(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $department = new Department($uuid, 'Testing', 'const', 12345);

        $this->departmentReadModelMock
            ->expects(self::once())
            ->method('getDepartmentById')
            ->with($uuid)
            ->willReturn($department);

        $result = $this->getSut()->handle(new GetDepartmentByIdQuery($uuid));

        self::assertEquals($department, $result);
    }

    #[Pure] private function getSut(): GetDepartmentByIdHandler
    {
        return new GetDepartmentByIdHandler(
            $this->departmentReadModelMock
        );
    }
}