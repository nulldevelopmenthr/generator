<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Path;

class TestPsr0Path extends Psr0Path
{
    public function isSourceCode(): bool
    {
        return false;
    }

    public function isSpecCode(): bool
    {
        return false;
    }

    public function isTestsCode(): bool
    {
        return true;
    }
}
