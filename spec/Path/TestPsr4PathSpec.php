<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Path;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestPsr4PathSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/tests/', $classBase = '');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Path\TestPsr4Path');
    }
    public function it_returns_its_tests_code_path()
    {
        $this->isSourceCode()->shouldReturn(false);
        $this->isSpecCode()->shouldReturn(false);
        $this->isTestsCode()->shouldReturn(true);
    }
}