<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator\PhpParser;

use NullDev\Skeleton\CodeGenerator\PhpParser\MethodFactory;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\AggregateRootIdGetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\CreateGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\ReadModelIdGetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\RepositoryConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec\InitializableGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec\LetGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\UuidCreateGenerator;
use PhpSpec\ObjectBehavior;

class MethodFactorySpec extends ObjectBehavior
{
    public function let(
        ConstructorGenerator $constructorGenerator,
        DeserializeGenerator $deserializeGenerator,
        GetterGenerator $getterGenerator,
        SerializeGenerator $serializeGenerator,
        ToStringGenerator $toStringGenerator,
        UuidCreateGenerator $uuidCreateGenerator,
        CreateGenerator $createGenerator,
        AggregateRootIdGetterGenerator $aggregateRootIdGetterGenerator,
        RepositoryConstructorGenerator $repositoryConstructorGenerator,
        ReadModelIdGetterGenerator $readModelIdGetterGenerator,
        LetGenerator $letGenerator,
        InitializableGenerator $initializableGenerator
    ) {
        $this->beConstructedWith(
            $constructorGenerator,
            $deserializeGenerator,
            $getterGenerator,
            $serializeGenerator,
            $toStringGenerator,
            $uuidCreateGenerator,
            $createGenerator,
            $aggregateRootIdGetterGenerator,
            $repositoryConstructorGenerator,
            $readModelIdGetterGenerator,
            $letGenerator,
            $initializableGenerator
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MethodFactory::class);
    }
}
