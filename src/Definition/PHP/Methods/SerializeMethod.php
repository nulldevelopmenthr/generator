<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Source\ImprovedClassSource;

class SerializeMethod implements Method
{
    private $classSource;

    public function __construct(ImprovedClassSource $classSource)
    {
        $this->classSource = $classSource;
    }

    public function getProperties(): array
    {
        return $this->classSource->getProperties();
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
        return 'serialize';
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
        return 'array';
    }
}
