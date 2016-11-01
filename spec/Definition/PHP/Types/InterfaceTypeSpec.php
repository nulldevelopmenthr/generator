<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Types;

use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use PhpSpec\ObjectBehavior;

class InterfaceTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('InterfaceType', 'Namespace1\\Namespace2');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InterfaceType::class);
    }

    public function it_exposes_namespace()
    {
        $this->getNamespace()->shouldReturn('Namespace1\\Namespace2');
    }

    public function it_exposes_class_name()
    {
        $this->getName()->shouldReturn('InterfaceType');
    }

    public function it_exposes_full_class_name()
    {
        $this->getFullName()->shouldReturn('Namespace1\\Namespace2\\InterfaceType');
    }

    public function it_can_be_created_without_namespace()
    {
        $this->beConstructedWith('InterfaceType');
        $this->getNamespace()->shouldReturn(null);
        $this->getName()->shouldReturn('InterfaceType');
        $this->getFullName()->shouldReturn('InterfaceType');
    }

    public function it_can_be_created_from_fully_qualified_name()
    {
        $result = $this->createFromFullyQualified('Namespace1\\Namespace2\\InterfaceType');

        $result->shouldBeAnInstanceOf(InterfaceType::class);
        $result->getNamespace()->shouldReturn('Namespace1\\Namespace2');
        $result->getName()->shouldReturn('InterfaceType');
        $result->getFullName()->shouldReturn('Namespace1\\Namespace2\\InterfaceType');
    }

    public function it_can_be_created_from_fully_qualified_name_without_namespace()
    {
        $result = $this->createFromFullyQualified('InterfaceType');

        $result->shouldBeAnInstanceOf(InterfaceType::class);
        $result->getNamespace()->shouldReturn(null);
        $result->getName()->shouldReturn('InterfaceType');
        $result->getFullName()->shouldReturn('InterfaceType');
    }
}
