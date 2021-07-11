<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Adapter;

use App\Application\Query\Department\GetDepartmentByIdHandler;
use App\Application\Query\Department\ViewModel\Department;
use App\Application\Query\Exception\NotFoundException;
use App\Domain\Employee\DepartmentId;
use App\Infrastructure\Adapter\DepartmentAdapter;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class DepartmentAdapterTest extends TestCase
{
    private GetDepartmentByIdHandler|MockObject $getDepartmentByIdHandlerMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->getDepartmentByIdHandlerMock = $this->createMock(GetDepartmentByIdHandler::class);
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenDepartmentExists(): void
    {
        $this->getDepartmentByIdHandlerMock
            ->expects(self::once())
            ->method('handle')
            ->willReturn(new Department(Uuid::uuid4()->toString(), 'Test', 'const', 1234));

        $result = $this->getSut()->isDepartmentExists(DepartmentId::fromString(Uuid::uuid4()->toString()));

        self::assertTrue($result);
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenDepartmentNonExists(): void
    {
        $this->getDepartmentByIdHandlerMock
            ->expects(self::once())
            ->method('handle')
            ->willThrowException(new NotFoundException('test'));

        $result = $this->getSut()->isDepartmentExists(DepartmentId::fromString(Uuid::uuid4()->toString()));

        self::assertFalse($result);
    }

    #[Pure] public function getSut(): DepartmentAdapter
    {
        return new DepartmentAdapter(
            $this->getDepartmentByIdHandlerMock,
        );
    }
}