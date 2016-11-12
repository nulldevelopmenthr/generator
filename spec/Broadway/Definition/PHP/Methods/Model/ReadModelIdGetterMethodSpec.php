<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\ReadModelIdGetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Parameter;
use PhpSpec\ObjectBehavior;

class ReadModelIdGetterMethodSpec extends ObjectBehavior
{
    public function let(Parameter $parameter)
    {
        $this->beConstructedWith($parameter);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ReadModelIdGetterMethod::class);
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
        $this->getMethodName()->shouldReturn('getId');
    }

    public function it_can_return_method_parameters()
    {
        $this->getMethodParameters()->shouldReturn([]);
    }

    public function it_has_return_type()
    {
        $this->hasMethodReturnType()->shouldReturn(true);
        $this->getMethodReturnType()->shouldReturn('string');
    }
}
