<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\SpecGenerator;

use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SpecGenerator\SpecGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpecGeneratorSpec extends ObjectBehavior
{
    public function let(ClassSourceFactory $factory)
    {
        $this->beConstructedWith($factory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SpecGenerator::class);
    }

    public function TODO_it_can_generate_spec_source_from_class_source(
        $factory,
        ImprovedClassSource $classSource,
        ClassType $classType,
        ImprovedClassSource $specSource
    ) {
        $classSource->getClassType()->willReturn($classType);
        $classType->getFullName()->willReturn('Namespace\\Class');

        $factory->create(Argument::type(ClassType::class))->willReturn($specSource);
        $this->generate($classSource)->shouldReturn($specSource);
    }
}
