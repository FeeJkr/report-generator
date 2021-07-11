<?php

declare(strict_types=1);

namespace App\UI\Web\Request;

use Assert\Assert;
use DateTime;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class AddNewEmployeeRequest extends Request
{
    private const DEPARTMENT_ID = 'department_id';
    private const FIRST_NAME = 'first_name';
    private const LAST_NAME = 'last_name';
    private const SALARY = 'salary';
    private const EMPLOYED_AT = 'employed_at';

    public function __construct(
        private string $departmentId,
        private string $firstName,
        private string $lastName,
        private float $salary,
        private DateTimeInterface $employedAt,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $requestData = $request->toArray();
        $departmentId = $requestData[self::DEPARTMENT_ID] ?? null;
        $firstName = $requestData[self::FIRST_NAME] ?? null;
        $lastName = $requestData[self::LAST_NAME] ?? null;
        $salary = isset($requestData[self::SALARY]) ? (float) $requestData[self::SALARY] : null;
        $employedAt = $requestData[self::EMPLOYED_AT] ?? null;

        Assert::lazy()
            ->that($departmentId, self::DEPARTMENT_ID)->notEmpty()->uuid()
            ->that($firstName, self::FIRST_NAME)->notEmpty()->string()->maxLength(255)
            ->that($lastName, self::LAST_NAME)->notEmpty()->string()->maxLength(255)
            ->that($salary, self::SALARY)->notEmpty()->float()
            ->that($employedAt, self::EMPLOYED_AT)->notEmpty()->date('Y-m-d')
            ->verifyNow();

        return new self(
            $departmentId,
            $firstName,
            $lastName,
            $salary,
            DateTime::createFromFormat('Y-m-d', $employedAt),
        );
    }

    public function getDepartmentId(): string
    {
        return $this->departmentId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getEmployedAt(): DateTimeInterface
    {
        return $this->employedAt;
    }
}