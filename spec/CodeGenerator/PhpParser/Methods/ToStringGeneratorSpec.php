<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\CodeGenerator\PhpParser\Methods;

use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ToStringGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ToStringGenerator');
    }
}
