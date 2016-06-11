<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Popular\Broadway;

use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandFactorySpec extends ObjectBehavior
{
    public function let(
        ClassType $className,
        Parameter $param1,
        Parameter $param2,
        ClassType $className1,
        ClassType $className2
    ) {
        $className1->getName()->willReturn('SomeClass', 'FirstNamespace');
        $className2->getName()->willReturn('OtherClass', 'SecondNamespace');
        $param1->getName()->willReturn('name1');
        $param1->hasClass()->willReturn(true);
        $param1->getClassType()->willReturn($className1);

        $param2->getName()->willReturn('name2');
        $param2->hasClass()->willReturn(true);
        $param2->getClassType()->willReturn($className2);

        $this->beConstructedWith($className, $params = [$param1, $param2]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Popular\Broadway\CommandFactory');
    }

    public function it_will_return_source()
    {
        $this->getSource()->shouldReturnAnInstanceOf(ImprovedClassSource::class);
    }

    public function it_has_class_name_in_source($className)
    {
        $this->getSource()->getClassType()->shouldReturn($className);
    }

    public function it_has_all_constructor_params_as_properties_in_source()
    {
        $this->getSource()->getProperties()->shouldHaveCount(2);
    }

    public function it_has_parameters_in_import()
    {
        $imports = $this->getSource()->getImports();
        $imports->shouldHaveCount(2);
    }

    public function it_has_constructor_and_two_getter_methods()
    {
        $this->getSource()->getMethods()->shouldHaveCount(3);
    }
}
