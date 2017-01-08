<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Types;

interface Type
{
    public function getName(): string;

    public function getFullName(): string;
}
