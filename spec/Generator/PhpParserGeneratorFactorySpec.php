<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Generator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhpParserGeneratorFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Generator\PhpParserGeneratorFactory');
    }
}
