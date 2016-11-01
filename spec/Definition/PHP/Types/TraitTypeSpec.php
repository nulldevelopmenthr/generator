<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Types;

use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use PhpSpec\ObjectBehavior;

class TraitTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('TraitType', 'Namespace1\\Namespace2');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TraitType::class);
    }

    public function it_exposes_namespace()
    {
        $this->getNamespace()->shouldReturn('Namespace1\\Namespace2');
    }

    public function it_exposes_class_name()
    {
        $this->getName()->shouldReturn('TraitType');
    }

    public function it_exposes_full_class_name()
    {
        $this->getFullName()->shouldReturn('Namespace1\\Namespace2\\TraitType');
    }

    public function it_can_be_created_without_namespace()
    {
        $this->beConstructedWith('TraitType');
        $this->getNamespace()->shouldReturn(null);
        $this->getName()->shouldReturn('TraitType');
        $this->getFullName()->shouldReturn('TraitType');
    }

    public function it_can_be_created_from_fully_qualified_name()
    {
        $result = $this->createFromFullyQualified('Namespace1\\Namespace2\\TraitType');

        $result->shouldBeAnInstanceOf(TraitType::class);
        $result->getNamespace()->shouldReturn('Namespace1\\Namespace2');
        $result->getName()->shouldReturn('TraitType');
        $result->getFullName()->shouldReturn('Namespace1\\Namespace2\\TraitType');
    }

    public function it_can_be_created_from_fully_qualified_name_without_namespace()
    {
        $result = $this->createFromFullyQualified('TraitType');

        $result->shouldBeAnInstanceOf(TraitType::class);
        $result->getNamespace()->shouldReturn(null);
        $result->getName()->shouldReturn('TraitType');
        $result->getFullName()->shouldReturn('TraitType');
    }
}
