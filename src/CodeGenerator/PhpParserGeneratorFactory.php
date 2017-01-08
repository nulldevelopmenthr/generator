<?php

declare(strict_types=1);

namespace NullDev\Skeleton\CodeGenerator;

use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\AggregateRootIdGetterGenerator;
use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\CreateGenerator;
use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\ReadModelIdGetterGenerator;
use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\RepositoryConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\ClassGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\MethodFactory;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\UuidCreateGenerator;
use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\ExposeConstructorArgumentsAsGettersGenerator;
use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\InitializableGenerator;
use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\LetGenerator;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PhpParserGeneratorFactory
{
    public static function create(): PhpParserGenerator
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
                new UuidCreateGenerator(new BuilderFactory()),
                new CreateGenerator(new BuilderFactory()),
                new AggregateRootIdGetterGenerator(new BuilderFactory()),
                new RepositoryConstructorGenerator(new BuilderFactory()),
                new ReadModelIdGetterGenerator(new BuilderFactory()),
                new LetGenerator(new BuilderFactory()),
                new InitializableGenerator(new BuilderFactory()),
                new ExposeConstructorArgumentsAsGettersGenerator(new BuilderFactory())
            ),
            new PrettyPrinter\Standard()
        );

        return $generator;
    }
}
