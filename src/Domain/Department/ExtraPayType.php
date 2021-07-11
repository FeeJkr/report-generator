<?php

declare(strict_types=1);

namespace App\Domain\Department;

use MyCLabs\Enum\Enum;

/**
 * @method static ExtraPayType CONST()
 * @method static ExtraPayType PERCENTAGE()
 */
final class ExtraPayType extends Enum
{
    private const CONST = 'const';
    private const PERCENTAGE = 'percentage';
}