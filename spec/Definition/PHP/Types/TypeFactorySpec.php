<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Types;

use NullDev\Skeleton\Definition\PHP\Types\TypeFactory;
use PhpSpec\ObjectBehavior;

class TypeFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TypeFactory::class);
    }
}
