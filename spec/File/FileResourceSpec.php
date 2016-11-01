<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\File;

use NullDev\Skeleton\File\FileResource;
use NullDev\Skeleton\Path\Path;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;

class FileResourceSpec extends ObjectBehavior
{
    public function let(Path $path, ImprovedClassSource $classSource)
    {
        $classSource->getFullName()->willReturn('Namespace\\ClassName');

        $this->beConstructedWith($path, $classSource);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FileResource::class);
    }

    public function it_know_file_name($path)
    {
        $path->getFileNameFor('Namespace\\ClassName')->willReturn('/var/www/somewhere/src/Namespace/ClassName.php');
        $this->getFileName()->shouldReturn('/var/www/somewhere/src/Namespace/ClassName.php');
    }
}
