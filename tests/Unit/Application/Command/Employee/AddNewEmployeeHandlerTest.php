<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\Employee;

use App\Application\Command\Employee\AddNewEmployeeCommand;
use App\Application\Command\Employee\AddNewEmployeeHandler;
use App\Domain\Employee\Contract\DepartmentContract;
use App\Domain\Employee\EmployeeRepository;
use DateInterval;
use DateTime;
use DomainException;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use UnexpectedValueException;

final class AddNewEmployeeHandlerTest extends TestCase
{
    private MockObject|EmployeeRepository $employeeRepositoryMock;
    private MockObject|DepartmentContract $departmentContractMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employeeRepositoryMock = $this->createMock(EmployeeRepository::class);
        $this->departmentContractMock = $this->createMock(DepartmentContract::class);
    }

    /**
     * @test
     */
    public function shouldCreateAndStoreEmployee(): void
    {
        $this->departmentContractMock->expects(self::once())->method('isDepartmentExists')->willReturn(true);
        $this->employeeRepositoryMock->expects(self::once())->method('store');

        $id = $this->getSut()->handle(
            new AddNewEmployeeCommand(
                Uuid::uuid4()->toString(),
                'Test',
                'Test',
                1234,
                new DateTime(),
            )
        );

        self::assertTrue(Uuid::isValid($id));
    }

    /**
     * @test
     */
    public function shouldReturnExceptionWithInvalidDate(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->departmentContractMock->expects(self::once())->method('isDepartmentExists')->willReturn(true);
        $this->employeeRepositoryMock->expects(self::never())->method('store');

        $this->getSut()->handle(
            new AddNewEmployeeCommand(
                Uuid::uuid4()->toString(),
                'Test',
                'Test',
                1234,
                (new DateTime)->add(new DateInterval('P1D')),
            )
        );
    }

    /**
     * @test
     */
    public function shouldReturnExceptionWithInvalidDepartmentId(): void
    {
        $this->expectException(DomainException::class);
        $this->departmentContractMock->expects(self::once())->method('isDepartmentExists')->willReturn(false);
        $this->employeeRepositoryMock->expects(self::never())->method('store');

        $this->getSut()->handle(
            new AddNewEmployeeCommand(
                Uuid::uuid4()->toString(),
                'Test',
                'Test',
                1234,
                new DateTime,
            )
        );
    }

    #[Pure] private function getSut(): AddNewEmployeeHandler
    {
        return new AddNewEmployeeHandler(
            $this->employeeRepositoryMock,
            $this->departmentContractMock,
        );
    }
}