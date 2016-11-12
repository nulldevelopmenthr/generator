<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods;

use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\ExposeConstructorArgumentsAsGettersGenerator;
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
