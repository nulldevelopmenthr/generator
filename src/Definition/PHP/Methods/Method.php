<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Methods;

interface Method
{
    public function getVisibility(): string;

    public function isStatic(): bool;

    public function getMethodName(): string;

    public function getMethodParameters(): array;

    public function hasMethodReturnType(): bool;

    public function getMethodReturnType(): string;
}
