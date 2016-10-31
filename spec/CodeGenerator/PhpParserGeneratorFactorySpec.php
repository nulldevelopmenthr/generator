<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator;

use PhpSpec\ObjectBehavior;

class PhpParserGeneratorFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory');
    }
}
