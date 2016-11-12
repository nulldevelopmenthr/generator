<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\PhpSpec\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\LetMethod;
use PhpSpec\ObjectBehavior;

class LetMethodSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($params = []);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LetMethod::class);
        $this->shouldHaveType(Method::class);
    }
}
