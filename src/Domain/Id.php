<?php

declare(strict_types=1);

namespace App\Domain;

use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use UnexpectedValueException;

abstract class Id
{
    private function __construct(private string $id){}

    public static function fromString(string $id): static
    {
        if (Uuid::isValid($id)) {
            return new static($id);
        }

        throw new UnexpectedValueException(sprintf('Uuid %s is invalid.', $id));
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->id;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->toString();
    }
}