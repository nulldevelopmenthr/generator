<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\File;

use Composer\Autoload\ClassLoader;
use NullDev\Skeleton\File\FileResource;
use NullDev\Skeleton\Path\Psr0Path;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileFactorySpec extends ObjectBehavior
{
    public function let(ClassLoader $classLoader, Psr0Path $path1)
    {
        $this->beConstructedWith($classLoader, [$path1]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\File\FileFactory');
    }

    public function it_will_create_file_resource(ImprovedClassSource $classSource, $path1)
    {
        $classSource->getFullName()->willReturn('Namespace\\ClassName');
        $path1->belongsTo('Namespace\\ClassName')->willReturn(true);

        $this->create($classSource)->shouldReturnAnInstanceOf(FileResource::class);
    }
}
