<?php

declare(strict_types=1);

namespace App\Application\Query;

final class Filter
{
    public function __construct(private string $fieldName, private string $value){}

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}