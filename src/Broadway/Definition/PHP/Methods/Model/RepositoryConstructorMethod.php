<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;

class RepositoryConstructorMethod implements Method
{
    private $params = [];
    private $modelClassType;

    public function __construct(ClassType $modelClassType)
    {
        $this->modelClassType = $modelClassType;
    }

    public function getModelClassType(): ClassType
    {
        return $this->modelClassType;
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
        return '__constructor';
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
        throw new \Exception('Err 43212311: Method return type not supported on constructor.');
    }
}
