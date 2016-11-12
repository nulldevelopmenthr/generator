<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\AggregateRootIdGetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Parameter;
use PhpSpec\ObjectBehavior;

class AggregateRootIdGetterMethodSpec extends ObjectBehavior
{
    public function let(Parameter $parameter)
    {
        $this->beConstructedWith($parameter);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AggregateRootIdGetterMethod::class);
        $this->shouldHaveType(Method::class);
    }

    public function it_knows_its_public()
    {
        $this->getVisibility()->shouldReturn('public');
    }

    public function it_knows_its_not_static_type()
    {
        $this->isStatic()->shouldReturn(false);
    }

    public function it_can_return_method_name()
    {
        $this->getMethodName()->shouldReturn('getAggregateRootId');
    }

    public function it_can_return_method_parameters()
    {
        $this->getMethodParameters()->shouldReturn([]);
    }

    public function it_knows_if_return_type_defined($parameter)
    {
        $parameter->hasClass()->willReturn(true);
        $parameter->getClassShortName()->willReturn('SomeClass');

        $this->hasMethodReturnType()->shouldReturn(true);

        $this->getMethodReturnType()->shouldReturn('SomeClass');
    }

    public function it_has_no_return_type_if_property_it_gets_has_no_class($parameter)
    {
        $parameter->hasClass()->willReturn(false);
        $this->hasMethodReturnType()->shouldReturn(false);
    }

    public function it_throws_error_on_trying_to_get_return_type_when_it_doesnt_exist($parameter)
    {
        $parameter->hasClass()->willReturn(false);
        $parameter->getClassShortName()->willReturn(null);
        $this->shouldThrow(\TypeError::class)->duringGetMethodReturnType();
    }
}
