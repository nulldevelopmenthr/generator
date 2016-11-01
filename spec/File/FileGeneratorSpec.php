<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\File;

use NullDev\Skeleton\CodeGenerator\PhpParserGenerator;
use NullDev\Skeleton\File\FileGenerator;
use NullDev\Skeleton\File\FileResource;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Filesystem\Filesystem;

class FileGeneratorSpec extends ObjectBehavior
{
    public function let(Filesystem $filesystem, PhpParserGenerator $codeGenerator)
    {
        $this->beConstructedWith($filesystem, $codeGenerator);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FileGenerator::class);
    }

    public function it_will_create_file(
        $filesystem,
        $codeGenerator,
        FileResource $fileResource,
        ImprovedClassSource $classSource
    ) {
        $fileResource->getClassSource()->willReturn($classSource);
        $fileResource->getFileName()->willReturn('filename.php');
        $codeGenerator->getOutput($classSource)->willReturn('code');

        $filesystem->dumpFile('filename.php', 'code')->shouldBeCalled();

        $this->create($fileResource)->shouldReturn(true);
    }
}
