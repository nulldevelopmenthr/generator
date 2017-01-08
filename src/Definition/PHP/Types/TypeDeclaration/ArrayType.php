<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration;

class ArrayType implements TypeDeclaration
{
    public function getName(): string
    {
        return 'array';
    }

    public function getFullName(): string
    {
        return 'array';
    }
}
