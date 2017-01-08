<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration;

class BoolType implements TypeDeclaration
{
    public function getName(): string
    {
        return 'bool';
    }

    public function getFullName(): string
    {
        return 'bool';
    }
}
