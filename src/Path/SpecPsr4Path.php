<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Path;

class SpecPsr4Path extends Psr4Path
{
    public function isSourceCode(): bool
    {
        return false;
    }

    public function isSpecCode(): bool
    {
        return true;
    }

    public function isTestsCode(): bool
    {
        return false;
    }
}
