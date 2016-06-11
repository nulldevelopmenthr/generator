<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Popular;

use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UuidFactorySpec extends ObjectBehavior
{
    public function let(ClassType $className)
    {
        $this->beConstructedWith($className);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Popular\UuidFactory');
    }

    public function it_will_return_source()
    {
        $this->getSource()->shouldReturnAnInstanceOf(ImprovedClassSource::class);
    }

    public function it_has_class_name_in_source($className)
    {
        $this->getSource()->getClassType()->shouldReturn($className);
    }

    public function it_has_one_property_in_source()
    {
        $this->getSource()->getProperties()->shouldHaveCount(1);
    }

    public function it_has_default_property_name()
    {
        $this->getSource()->getProperties()[0]->getName()->shouldReturn('id');
    }

    public function it_has_ramsey_uuid_to_import()
    {
        $imports = $this->getSource()->getImports();
        $imports[0]->shouldBeAnInstanceOf(ClassType::class);
        $imports[0]->getFullName()->shouldReturn('Ramsey\Uuid\Uuid');
    }

    public function it_has_four_methods()
    {
        $this->getSource()->getMethods()->shouldHaveCount(4);
    }
}
