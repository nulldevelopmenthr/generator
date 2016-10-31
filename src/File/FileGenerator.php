<?php

declare(strict_types=1);

namespace NullDev\Skeleton\File;

use NullDev\Skeleton\CodeGenerator\PhpParserGenerator;
use Symfony\Component\Filesystem\Filesystem;

class FileGenerator
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var PhpParserGenerator
     */
    private $codeGenerator;

    public function __construct(Filesystem $filesystem, PhpParserGenerator $codeGenerator)
    {
        $this->filesystem    = $filesystem;
        $this->codeGenerator = $codeGenerator;
    }

    public function create(FileResource $fileResource)
    {
        $fileName = $fileResource->getFileName();
        $content  = $this->codeGenerator->getOutput($fileResource->getClassSource());

        $this->filesystem->dumpFile($fileName, $content);

        return true;
    }
}
