<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\SourceFactory\Broadway;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventSourcingRepositorySourceFactorySpec extends ObjectBehavior
{
    public function let(ClassSourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->beConstructedWith($sourceFactory, $definitionFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\SourceFactory\Broadway\EventSourcingRepositorySourceFactory');
    }

    public function it_will_create_source_from_given_class_type_and_target_entity(
        ClassSourceFactory $sourceFactory,
        DefinitionFactory $definitionFactory,
        ClassType $classType,
        ImprovedClassSource $classSource,
        Parameter $parameter,
        ClassType $parameterClassType,
        RepositoryConstructorMethod $repositoryConstructorMethod
    ) {
        $parameter
            ->getClassType()
            ->willReturn($parameterClassType);

        $sourceFactory
            ->create($classType)
            ->willReturn($classSource);

        $definitionFactory
            ->createBroadwayModelRepositoryConstructorMethod($parameterClassType)
            ->shouldBeCalled()
            ->willReturn($repositoryConstructorMethod);

        $this->create($classType, $parameter)
            ->shouldReturn($classSource);
    }
}
