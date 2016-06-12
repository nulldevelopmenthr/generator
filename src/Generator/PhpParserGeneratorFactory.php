<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Generator;

use NullDev\Skeleton\Generator\PhpParser\ClassGenerator;
use NullDev\Skeleton\Generator\PhpParser\MethodFactory;
use NullDev\Skeleton\Generator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\UuidCreateGenerator;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter;

class PhpParserGeneratorFactory
{
    public static function create() : PhpParserGenerator
    {
        $generator = new PhpParserGenerator(
            new BuilderFactory(),
            new ClassGenerator(
                new BuilderFactory()
            ),
            new MethodFactory(
                new ConstructorGenerator(new BuilderFactory()),
                new DeserializeGenerator(new BuilderFactory()),
                new GetterGenerator(new BuilderFactory()),
                new SerializeGenerator(new BuilderFactory()),
                new ToStringGenerator(new BuilderFactory()),
                new UuidCreateGenerator(new BuilderFactory())
            ),
            new PrettyPrinter\Standard()
        );

        return $generator;
    }
}
