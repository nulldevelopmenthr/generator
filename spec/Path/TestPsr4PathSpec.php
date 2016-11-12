<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Path;

use NullDev\Skeleton\Path\TestPsr4Path;
use PhpSpec\ObjectBehavior;

class TestPsr4PathSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/tests/', $classBase = '');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TestPsr4Path::class);
    }

    public function it_returns_its_tests_code_path()
    {
        $this->isSourceCode()->shouldReturn(false);
        $this->isSpecCode()->shouldReturn(false);
        $this->isTestsCode()->shouldReturn(true);
    }
}
