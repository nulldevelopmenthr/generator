<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Source;

use NullDev\Skeleton\Definition\PHP\Types\ClassType;

class SourceFactory
{
    public function create(ClassType $classType)
    {
        return new ImprovedClassSource($classType);
    }
}
