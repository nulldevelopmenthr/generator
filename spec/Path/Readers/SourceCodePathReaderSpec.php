<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Path\Readers;

use NullDev\Skeleton\Path\Readers\SourceCodePathReader;
use PhpSpec\ObjectBehavior;

class SourceCodePathReaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SourceCodePathReader::class);
    }
}
