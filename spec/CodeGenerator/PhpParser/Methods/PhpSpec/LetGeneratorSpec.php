<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec;

use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec\LetGenerator;
use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;

class LetGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LetGenerator::class);
    }
}
