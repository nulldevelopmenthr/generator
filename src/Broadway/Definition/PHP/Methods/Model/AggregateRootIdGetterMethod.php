<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Parameter;

class AggregateRootIdGetterMethod implements Method
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
        return 'getAggregateRootId';
    }

    public function getMethodParameters(): array
    {
        return [];
    }

    public function hasMethodReturnType(): bool
    {
        return $this->parameter->hasClass();
    }

    public function getMethodReturnType(): string
    {
        return $this->parameter->getClassShortName();
    }
}
