<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Types;

use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\BoolType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\FloatType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\IntType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;

class TypeFactory
{
    public static function createFromName(string $name): Type
    {
        $name = str_replace('/', '\\', $name);

        if ('' === $name) {
            throw new \Exception('ERR 34145234: Params without classes are not supported yet!');
        }

        if ('string' === $name) {
            return new StringType();
        } elseif ('array' === $name) {
            return new ArrayType();
        } elseif ('int' === $name) {
            return new IntType();
        } elseif ('float' === $name) {
            return new FloatType();
        } elseif ('bool' === $name) {
            return new BoolType();
        }

        return ClassType::create($name);
    }
}
