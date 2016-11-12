<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Path;

use NullDev\Skeleton\Path\SpecPsr4Path;
use PhpSpec\ObjectBehavior;

class SpecPsr4PathSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/spec/', $classBase = '');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SpecPsr4Path::class);
    }

    public function it_returns_its_spec_code_path()
    {
        $this->isSourceCode()->shouldReturn(false);
        $this->isSpecCode()->shouldReturn(true);
        $this->isTestsCode()->shouldReturn(false);
    }
}
