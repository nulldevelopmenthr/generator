<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\SourceFactory;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UuidIdentitySourceFactorySpec extends ObjectBehavior
{
    public function let(ClassSourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->beConstructedWith($sourceFactory, $definitionFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UuidIdentitySourceFactory::class);
    }

    public function it_will_create_source_from_given_class_type(
        ClassSourceFactory $sourceFactory,
        DefinitionFactory $definitionFactory,
        ClassType $classType,
        ImprovedClassSource $classSource,
        Parameter $parameter,
        ConstructorMethod $constructorMethod,
        ToStringMethod $toStringMethod,
        UuidCreateMethod $uuidCreateMethod
    ) {
        $sourceFactory->create($classType)->willReturn($classSource);

        $definitionFactory
            ->createParameter('id', Argument::type(StringType::class))
            ->shouldBeCalled()
            ->willReturn($parameter);
        $definitionFactory
            ->createConstructorMethod([$parameter])
            ->shouldBeCalled()
            ->willReturn($constructorMethod);
        $definitionFactory
            ->createToStringMethod($parameter)
            ->shouldBeCalled()
            ->willReturn($toStringMethod);
        $definitionFactory
            ->createUuidCreateMethod($classType)
            ->shouldBeCalled()
            ->willReturn($uuidCreateMethod);

        $this->create($classType)->shouldReturn($classSource);
    }
}
