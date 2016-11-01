<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP;

use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use PhpSpec\ObjectBehavior;

class ParameterSpec extends ObjectBehavior
{
    public function let(ClassType $className)
    {
        $this->beConstructedWith($name = 'param', $className);
    }

    public function it_can_be_instantiated_without_class()
    {
        $this->beConstructedWith($name = 'param');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Parameter::class);
    }
}
