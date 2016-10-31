<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model;

use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryConstructorMethodSpec extends ObjectBehavior
{
    public function let(ClassType $classType)
    {
        $this->beConstructedWith($classType);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\RepositoryConstructorMethod');
    }
}
