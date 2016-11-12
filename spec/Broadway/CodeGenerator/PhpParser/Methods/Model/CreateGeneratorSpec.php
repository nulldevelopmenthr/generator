<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model;

use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\CreateGenerator;
use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;

class CreateGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateGenerator::class);
    }
}
