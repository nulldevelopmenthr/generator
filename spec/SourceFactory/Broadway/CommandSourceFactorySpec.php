<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\SourceFactory\Broadway;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\Source\SourceFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandSourceFactorySpec extends ObjectBehavior
{
    public function let(SourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->beConstructedWith($sourceFactory, $definitionFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\SourceFactory\Broadway\CommandSourceFactory');
    }

    public function it_will_create_source_from_given_class_type_and_constructor_params(
        SourceFactory $sourceFactory,
        DefinitionFactory $definitionFactory,
        ClassType $classType,
        ImprovedClassSource $classSource,
        Parameter $parameter1,
        Parameter $parameter2,
        ConstructorMethod $constructorMethod
    ) {
        $sourceFactory
            ->create($classType)
            ->willReturn($classSource);

        $definitionFactory
            ->createConstructorMethod([$parameter1, $parameter2])
            ->shouldBeCalled()
            ->willReturn($constructorMethod);

        $this->create($classType, [$parameter1, $parameter2])
            ->shouldReturn($classSource);
    }
}
