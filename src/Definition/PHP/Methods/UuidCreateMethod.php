<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Types\ClassType;

class UuidCreateMethod implements Method
{
    private $classToBuild;

    /**
     * UuidCreateMethod constructor.
     *
     * @param $classToBuild
     */
    public function __construct(ClassType $classToBuild)
    {
        $this->classToBuild = $classToBuild;
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
        return [];
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
