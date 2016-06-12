<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\File;

use Composer\Autoload\ClassLoader;
use NullDev\Skeleton\Path\Path;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileResourceSpec extends ObjectBehavior
{
    public function let(ClassLoader $classLoader, Path $path, ImprovedClassSource $classSource)
    {
        $classSource->getFullName()->willReturn('Namespace\\ClassName');

        $this->beConstructedWith($classLoader, $path, $classSource);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\File\FileResource');
    }

    public function it_know_file_name($path)
    {
        $path->getFileNameFor('Namespace\\ClassName')->willReturn('/var/www/somewhere/src/Namespace/ClassName.php');
        $this->getFileName()->shouldReturn('/var/www/somewhere/src/Namespace/ClassName.php');
    }

    public function it_knows_if_file_already_exists($classLoader)
    {
        $classLoader->findFile('Namespace\\ClassName')->willReturn(true);
        $this->fileExists()->shouldReturn(true);
    }
}
