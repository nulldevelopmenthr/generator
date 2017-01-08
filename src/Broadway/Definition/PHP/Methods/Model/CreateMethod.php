<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;

class CreateMethod implements Method
{
    private $classToBuild;
    private $params;

    public function __construct(ClassType $classToBuild, array $params)
    {
        $this->classToBuild = $classToBuild;
        $this->params       = $params;
    }

    public function getVisibility(): string
    {
        return 'public';
    }

    public function isStatic(): bool
    {
        return true;
    }

    public function getMethodName(): string
    {
        return 'create';
    }

    public function getMethodParameters(): array
    {
        return $this->params;
    }

    public function hasMethodReturnType(): bool
    {
        return true;
    }

    public function getMethodReturnType(): string
    {
        return $this->classToBuild->getName();
    }
}
