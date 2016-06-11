<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Generator\PhpParser;

use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Generator\PhpParser\ClassGenerator');
    }
}
