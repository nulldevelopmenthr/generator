<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Broadway\SourceFactory\Read\DoctrineOrm;

use NullDev\Skeleton\Broadway\SourceFactory\Read\DoctrineOrm\ReadRepositorySourceFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;

class ReadRepositorySourceFactorySpec extends ObjectBehavior
{
    public function let(ClassSourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->beConstructedWith($sourceFactory, $definitionFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ReadRepositorySourceFactory::class);
    }

    public function it_will_create_source_from_given_class_type_and_constructor_params(
        ClassSourceFactory $sourceFactory,
        ClassType $classType,
        ImprovedClassSource $classSource
    ) {
        $sourceFactory
            ->create($classType)
            ->willReturn($classSource);

        $this->create($classType)
            ->shouldReturn($classSource);
    }
}
