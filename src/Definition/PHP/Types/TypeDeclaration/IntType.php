<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration;

class IntType implements TypeDeclaration
{
    public function getName(): string
    {
        return 'int';
    }

    public function getFullName(): string
    {
        return 'int';
    }
}
