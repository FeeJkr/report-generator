<?php

declare(strict_types=1);

namespace App\Application\Query\Department\ViewModel;

final class Department
{
    public function __construct(
        private string $id,
        private string $name,
        private string $extraPayType,
        private float $extraPayValue,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

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