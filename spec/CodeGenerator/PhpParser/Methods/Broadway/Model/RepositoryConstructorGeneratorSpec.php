<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model;

use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\RepositoryConstructorGenerator;
use PhpParser\BuilderFactory;
use PhpSpec\ObjectBehavior;

class RepositoryConstructorGeneratorSpec extends ObjectBehavior
{
    public function let(BuilderFactory $builderFactory)
    {
        $this->beConstructedWith($builderFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RepositoryConstructorGenerator::class);
    }
}
