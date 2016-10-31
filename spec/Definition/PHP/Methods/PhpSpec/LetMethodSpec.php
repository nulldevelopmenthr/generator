<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Methods\PhpSpec;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use PhpSpec\ObjectBehavior;

class LetMethodSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($params = []);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\LetMethod');
        $this->shouldHaveType(Method::class);
    }
}
