<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\File;

use Composer\Autoload\ClassLoader;
use NullDev\Skeleton\Path\Path;
use NullDev\Skeleton\Source\ImprovedClassSource;

class FileResource
{
    /** @var ClassLoader */
    private $classLoader;
    /** @var Path */
    private $path;
    /** @var ImprovedClassSource */
    private $classSource;

    public function __construct(ClassLoader $classLoader, Path $path, ImprovedClassSource $classSource)
    {
        $this->classLoader = $classLoader;
        $this->path        = $path;
        $this->classSource = $classSource;
    }

    /**
     * @return ImprovedClassSource
     */
    public function getClassSource() : ImprovedClassSource
    {
        return $this->classSource;
    }

    public function getFileName() : string
    {
        return $this->path->getFileNameFor($this->classSource->getFullName());
    }

    public function fileExists() : bool
    {
        if (false === $this->classLoader->findFile($this->classSource->getFullName())) {
            return false;
        }

        return true;
    }
}
