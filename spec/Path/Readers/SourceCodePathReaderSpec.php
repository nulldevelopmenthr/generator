<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Path\Readers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SourceCodePathReaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Path\Readers\SourceCodePathReader');
    }
}
