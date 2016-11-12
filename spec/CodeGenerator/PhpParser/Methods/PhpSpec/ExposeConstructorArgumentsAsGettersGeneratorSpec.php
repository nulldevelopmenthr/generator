<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec;

use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec\ExposeConstructorArgumentsAsGettersGenerator;
use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;

class ExposeConstructorArgumentsAsGettersGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ExposeConstructorArgumentsAsGettersGenerator::class);
    }
}
