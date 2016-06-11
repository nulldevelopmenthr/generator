<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Path;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpecPsr4PathSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/spec/', $classBase = '');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Path\SpecPsr4Path');
    }
    public function it_returns_its_spec_code_path()
    {
        $this->isSourceCode()->shouldReturn(false);
        $this->isSpecCode()->shouldReturn(true);
        $this->isTestsCode()->shouldReturn(false);
    }
}
