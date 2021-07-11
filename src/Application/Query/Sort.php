<?php

declare(strict_types=1);

namespace App\Application\Query;

use UnexpectedValueException;

final class Sort
{
    private const AVAILABLE_ORDER = ['ASC', 'DESC'];

    private string $columnName;
    private string $order;

    public function __construct(string $columnName, string $order)
    {
        $order = strtoupper($order);

        if (!in_array($order, self::AVAILABLE_ORDER, true)) {
            throw new UnexpectedValueException('Sort order can be only ASC or DESC.');
        }

        $this->columnName = $columnName;
        $this->order = $order;
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getOrder(): string
    {
        return $this->order;
    }
}