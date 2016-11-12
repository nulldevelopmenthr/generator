<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\PhpSpec\Definition\PHP\Methods;

use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\ExposeConstructorArgumentsAsGettersMethod;
use PhpSpec\ObjectBehavior;

class ExposeConstructorArgumentsAsGettersMethodSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ExposeConstructorArgumentsAsGettersMethod::class);
    }
}
