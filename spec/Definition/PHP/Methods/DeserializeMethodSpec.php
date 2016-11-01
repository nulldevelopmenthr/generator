<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\DeserializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;

class DeserializeMethodSpec extends ObjectBehavior
{
    public function let(ImprovedClassSource $classSource)
    {
        $classSource->getName()->willReturn('SomeClass');
        $classSource->getProperties()->willReturn([]);

        $this->beConstructedWith($classSource);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DeserializeMethod::class);
        $this->shouldHaveType(Method::class);
    }

    public function it_knows_its_public()
    {
        $this->getVisibility()->shouldReturn('public');
    }

    public function it_knows_its_static_type()
    {
        $this->isStatic()->shouldReturn(true);
    }

    public function it_can_return_method_name()
    {
        $this->getMethodName()->shouldReturn('deserialize');
    }

    public function it_can_return_method_parameters()
    {
        $this->getMethodParameters()->shouldHaveCount(1);
    }

    public function it_has_return_type_defined()
    {
        $this->hasMethodReturnType()->shouldReturn(true);
        $this->getMethodReturnType()->shouldReturn('SomeClass');
    }
}
