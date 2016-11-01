<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use PhpSpec\ObjectBehavior;

class PhpParserGeneratorFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PhpParserGeneratorFactory::class);
    }
}
