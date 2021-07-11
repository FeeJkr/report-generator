<?php

declare(strict_types=1);

namespace App\UI\Web\Request;

use App\Application\Query\Filter;
use App\Application\Query\FiltersCollection;
use App\Application\Query\Sort;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GeneratePayrollReportRequest extends Request
{
    public function __construct(
        private ?Sort $sort,
        private FiltersCollection $filters,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $sort = $request->get('sort');
        $filters = $request->get('filter', []);

        Assert::lazy()
            ->that($sort, 'sort')->nullOr()->isArray()->count(1)
            ->that($filters, 'filter')->isArray()
            ->verifyNow();

        return new self(
            $sort === null ? null : new Sort(array_key_first($sort), reset($sort)),
            new FiltersCollection(
                ...array_map(
                    static fn (string $fieldName, string $value) => new Filter($fieldName, $value),
                    array_keys($filters),
                    $filters
                )
            )
        );
    }

    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    public function getFilters(): FiltersCollection
    {
        return $this->filters;
    }
}