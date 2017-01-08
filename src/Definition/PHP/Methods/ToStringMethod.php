<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Parameter;

class ToStringMethod implements Method
{
    private $parameter;

    public function __construct(Parameter $parameter)
    {
        $this->parameter = $parameter;
    }

    public function getPropertyName()
    {
        return $this->parameter->getName();
    }

    public function getVisibility(): string
    {
        return 'public';
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function getMethodName(): string
    {
        return '__toString';
    }

    public function getMethodParameters(): array
    {
        return [];
    }

    public function hasMethodReturnType(): bool
    {
        return true;
    }

    public function getMethodReturnType(): string
    {
        return 'string';
    }
}
