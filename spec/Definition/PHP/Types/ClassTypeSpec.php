<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Types;

use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use PhpSpec\ObjectBehavior;

class ClassTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('ClassType', 'Namespace1\\Namespace2');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ClassType::class);
    }

    public function it_exposes_namespace()
    {
        $this->getNamespace()->shouldReturn('Namespace1\\Namespace2');
    }

    public function it_exposes_class_name()
    {
        $this->getName()->shouldReturn('ClassType');
    }

    public function it_exposes_full_class_name()
    {
        $this->getFullName()->shouldReturn('Namespace1\\Namespace2\\ClassType');
    }

    public function it_can_be_created_without_namespace()
    {
        $this->beConstructedWith('ClassType');
        $this->getNamespace()->shouldReturn(null);
        $this->getName()->shouldReturn('ClassType');
        $this->getFullName()->shouldReturn('ClassType');
    }

    public function it_can_be_created_from_fully_qualified_name()
    {
        $result = $this->createFromFullyQualified('Namespace1\\Namespace2\\ClassType');

        $result->shouldBeAnInstanceOf(ClassType::class);
        $result->getNamespace()->shouldReturn('Namespace1\\Namespace2');
        $result->getName()->shouldReturn('ClassType');
        $result->getFullName()->shouldReturn('Namespace1\\Namespace2\\ClassType');
    }

    public function it_can_be_created_from_fully_qualified_name_without_namespace()
    {
        $result = $this->createFromFullyQualified('ClassType');

        $result->shouldBeAnInstanceOf(ClassType::class);
        $result->getNamespace()->shouldReturn(null);
        $result->getName()->shouldReturn('ClassType');
        $result->getFullName()->shouldReturn('ClassType');
    }
}
