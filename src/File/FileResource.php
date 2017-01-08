<?php

declare(strict_types=1);

namespace NullDev\Skeleton\File;

use NullDev\Skeleton\Path\Path;
use NullDev\Skeleton\Source\ImprovedClassSource;

class FileResource
{
    /** @var Path */
    private $path;
    /** @var ImprovedClassSource */
    private $classSource;

    public function __construct(Path $path, ImprovedClassSource $classSource)
    {
        $this->path        = $path;
        $this->classSource = $classSource;
    }

    /**
     * @return ImprovedClassSource
     */
    public function getClassSource(): ImprovedClassSource
    {
        return $this->classSource;
    }

    public function getFileName(): string
    {
        return $this->path->getFileNameFor($this->classSource->getFullName());
    }
}
