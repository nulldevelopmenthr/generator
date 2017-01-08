<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Path;

use Exception;

class Psr4Path implements Path
{
    private $pathBase;
    private $classBase;

    public function __construct(string $pathBase, string $classBase)
    {
        if (!empty($classBase) && substr($classBase, -1) !== '\\') {
            throw new Exception('Err 58734376: Class base must finish with "\\" ');
        }
        if (substr($pathBase, -1) !== '/') {
            throw new Exception('Err 5873433: Path base must finish with "/" ');
        }
        $this->pathBase  = $pathBase;
        $this->classBase = $classBase;
    }

    public function isSourceCode(): bool
    {
        return true;
    }

    public function isSpecCode(): bool
    {
        return false;
    }

    public function isTestsCode(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getPathBase(): string
    {
        return $this->pathBase;
    }

    /**
     * @return string
     */
    public function getClassBase(): string
    {
        return $this->classBase;
    }

    public function belongsTo(string $className): bool
    {
        if ($this->classBase === '') {
            return true;
        }

        if (0 === strpos($className, $this->classBase)) {
            return true;
        }

        return false;
    }

    public function getFileNameFor(string $className): string
    {
        if (!$this->belongsTo($className)) {
            throw new Exception('Err 58733211: Class name "'.$className.'" doesnt belong to this path!');
        }

        //If not empty class base, remove class base from class name.
        if (!empty($this->classBase)) {
            $className = substr($className, strlen($this->classBase));
        }

        $fileName = str_replace('\\', '/', $className);

        return $this->pathBase.$fileName.'.php';
    }
}
