<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use PhpSpec\ObjectBehavior;

class UuidCreateMethodSpec extends ObjectBehavior
{
    public function let(ClassType $className)
    {
        $this->beConstructedWith($className);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UuidCreateMethod::class);
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
        $this->getMethodName()->shouldReturn('create');
    }

    public function it_has_no_method_parameters()
    {
        $this->getMethodParameters()->shouldReturn([]);
    }

    public function it_has_return_type($className)
    {
        $className->getName()->willReturn('zzz');
        $this->hasMethodReturnType()->shouldReturn(true);
        $this->getMethodReturnType()->shouldReturn('zzz');
    }
}
