<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods;

use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\LetGenerator;
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
