<?php

declare(strict_types=1);

namespace App\Application\Command\Department;

final class AddNewDepartmentCommand
{
    public function __construct(
        private string $name,
        private string $extraPayType,
        private float $extraPayValue,
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getExtraPayType(): string
    {
        return $this->extraPayType;
    }

    public function getExtraPayValue(): float
    {
        return $this->extraPayValue;
    }
}