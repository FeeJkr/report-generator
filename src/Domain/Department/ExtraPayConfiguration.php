<?php

declare(strict_types=1);

namespace App\Domain\Department;

final class ExtraPayConfiguration
{
    public function __construct(private ExtraPayType $type, private float $value){}

    public function getType(): ExtraPayType
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}