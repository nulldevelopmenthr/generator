<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use PhpSpec\ObjectBehavior;

class ConstructorMethodSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($params = []);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ConstructorMethod::class);
        $this->shouldHaveType(Method::class);
    }
}
