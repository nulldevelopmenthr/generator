<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\Source\ImprovedClassSource;

class DeserializeMethod implements Method
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
        return true;
    }

    public function getMethodName(): string
    {
        return 'deserialize';
    }

    public function getMethodParameters(): array
    {
        return [new Parameter('data', new ArrayType())];
    }

    public function hasMethodReturnType(): bool
    {
        return true;
    }

    public function getMethodReturnType(): string
    {
        return $this->classSource->getName();
    }
}
