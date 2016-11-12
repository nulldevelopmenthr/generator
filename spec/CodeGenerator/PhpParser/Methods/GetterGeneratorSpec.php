<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator\PhpParser\Methods;

use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\GetterGenerator;
use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;

class GetterGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GetterGenerator::class);
    }
}
