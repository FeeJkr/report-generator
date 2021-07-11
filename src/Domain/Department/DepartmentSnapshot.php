<?php

declare(strict_types=1);

namespace App\Domain\Department;

final class DepartmentSnapshot
{
    public function __construct(
        private string $id,
        private string $name,
        private string $extraPaymentType,
        private float $extraPaymentValue
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExtraPaymentType(): string
    {
        return $this->extraPaymentType;
    }

    public function getExtraPaymentValue(): float
    {
        return $this->extraPaymentValue;
    }
}