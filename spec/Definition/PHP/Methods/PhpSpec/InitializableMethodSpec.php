<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Methods\PhpSpec;

use NullDev\Skeleton\Definition\PHP\Methods\Method;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InitializableMethodSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($shouldHaveTypes = []);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\InitializableMethod');
        $this->shouldHaveType(Method::class);
    }
}
