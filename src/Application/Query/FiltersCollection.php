<?php

declare(strict_types=1);

namespace App\Application\Query;

final class FiltersCollection
{
    private array $items;

    public function __construct(Filter ...$items)
    {
        $this->items = $items;
    }

    public function add(Filter $filter): void
    {
        $this->items[] = $filter;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}