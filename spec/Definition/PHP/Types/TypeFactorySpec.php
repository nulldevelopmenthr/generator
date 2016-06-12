<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Definition\PHP\Types;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypeFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Definition\PHP\Types\TypeFactory');
    }
}
