<?php

declare(strict_types=1);

namespace App\Domain\Department;

use JetBrains\PhpStorm\Pure;

final class Department
{
    public function __construct(
        private DepartmentId $id,
        private string $name,
        private ExtraPayConfiguration $extraPayConfiguration
    ){}

    public static function createNew(string $name, ExtraPayType $extraPayType, float $extraPayValue): self
    {
        return new self(
            DepartmentId::generate(),
            $name,
            new ExtraPayConfiguration($extraPayType, $extraPayValue)
        );
    }

    #[Pure]
    public function getSnapshot(): DepartmentSnapshot
    {
        return new DepartmentSnapshot(
            $this->id->toString(),
            $this->name,
            $this->extraPayConfiguration->getType()->getValue(),
            $this->extraPayConfiguration->getValue(),
        );
    }
}