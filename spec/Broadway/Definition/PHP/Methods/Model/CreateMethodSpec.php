<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\CreateMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use PhpSpec\ObjectBehavior;

class CreateMethodSpec extends ObjectBehavior
{
    public function let(ClassType $className, Parameter $param1)
    {
        $this->beConstructedWith($className, $parameters = [$param1]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateMethod::class);
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

    public function it_has_no_method_parameters($param1)
    {
        $this->getMethodParameters()->shouldReturn([$param1]);
    }

    public function it_has_return_type($className)
    {
        $className->getName()->willReturn('zzz');
        $this->hasMethodReturnType()->shouldReturn(true);
        $this->getMethodReturnType()->shouldReturn('zzz');
    }
}
