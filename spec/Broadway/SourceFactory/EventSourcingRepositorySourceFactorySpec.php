<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Broadway\SourceFactory;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Broadway\SourceFactory\EventSourcingRepositorySourceFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;

class EventSourcingRepositorySourceFactorySpec extends ObjectBehavior
{
    public function let(ClassSourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->beConstructedWith($sourceFactory, $definitionFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EventSourcingRepositorySourceFactory::class);
    }

    public function it_will_create_source_from_given_class_type_and_target_entity(
        ClassSourceFactory $sourceFactory,
        DefinitionFactory $definitionFactory,
        ClassType $classType,
        ImprovedClassSource $classSource,
        ClassType $modelClassType,
        RepositoryConstructorMethod $repositoryConstructorMethod
    ) {
        $sourceFactory
            ->create($classType)
            ->willReturn($classSource);

        $definitionFactory
            ->createBroadwayModelRepositoryConstructorMethod($modelClassType)
            ->shouldBeCalled()
            ->willReturn($repositoryConstructorMethod);

        $this->create($classType, $modelClassType)
            ->shouldReturn($classSource);
    }
}
