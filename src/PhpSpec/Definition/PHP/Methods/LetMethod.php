<?php

declare(strict_types=1);

namespace NullDev\Skeleton\PhpSpec\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\Method;

class LetMethod implements Method
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getParamsAsClassTypes(): array
    {
        $result = [];
        foreach ($this->params as $param) {
            if ($param->hasClass()) {
                $result[] = $param->getClassType();
            }
        }

        return $result;
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
        return 'let';
    }

    public function getMethodParameters(): array
    {
        return $this->params;
    }

    public function hasMethodReturnType(): bool
    {
        return false;
    }

    public function getMethodReturnType(): string
    {
        throw new \Exception('Err 543534: PhpSpec LetMethod doesnt use return types.');
    }
}
