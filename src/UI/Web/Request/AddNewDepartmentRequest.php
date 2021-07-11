<?php

declare(strict_types=1);

namespace App\UI\Web\Request;

use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class AddNewDepartmentRequest extends Request
{
    private const NAME = 'name';
    private const EXTRA_PAY_TYPE = 'extra_pay_type';
    private const EXTRA_PAY_VALUE = 'extra_pay_value';

    public function __construct(
        private string $name,
        private string $extraPayType,
        private float $extraPayValue,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $extraPayType = $requestData[self::EXTRA_PAY_TYPE] ?? null;
        $extraPayValue = isset($requestData[self::EXTRA_PAY_VALUE])
            ? (float) $requestData[self::EXTRA_PAY_VALUE]
            : null;

        Assert::lazy()
            ->that($name, self::NAME)->notEmpty()->string()->maxLength(255)
            ->that($extraPayType, self::EXTRA_PAY_TYPE)->notEmpty()->string()
            ->that($extraPayValue, self::EXTRA_PAY_VALUE)->notEmpty()->float()
            ->verifyNow();

        return new self(
            $name,
            $extraPayType,
            $extraPayValue,
        );
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