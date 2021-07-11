<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\Department;

use App\Application\Command\Department\AddNewDepartmentCommand;
use App\Application\Command\Department\AddNewDepartmentHandler;
use App\Domain\Department\DepartmentRepository;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use UnexpectedValueException;

final class AddNewDepartmentHandlerTest extends TestCase
{
    private MockObject|DepartmentRepository $departmentRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->departmentRepositoryMock = $this->createMock(DepartmentRepository::class);
    }

    /**
     * @test
     */
    public function shouldHandleAndStoreWithValidData(): void
    {
        $this->departmentRepositoryMock->expects(self::once())->method('store');

        $id = $this->getSut()->handle(
            new AddNewDepartmentCommand('Testing', 'const', 1234)
        );

        self::assertTrue(Uuid::isValid($id));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionOnInvalidExtraPayType(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->departmentRepositoryMock->expects(self::never())->method('store');

        $this->getSut()->handle(
            new AddNewDepartmentCommand('Testing', 'test_invalid_data', 1234),
        );
    }

    #[Pure] public function getSut(): AddNewDepartmentHandler
    {
        return new AddNewDepartmentHandler(
            $this->departmentRepositoryMock
        );
    }
}