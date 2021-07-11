<?php

declare(strict_types=1);

namespace App\Application\Query\PayrollReport\ViewModel;

final class Report
{
    private array $items;

    public function __construct(ReportItem ...$items)
    {
        $this->items = $items;
    }

    public function add(ReportItem $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}