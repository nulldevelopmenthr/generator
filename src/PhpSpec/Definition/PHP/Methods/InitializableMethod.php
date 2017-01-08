<?php

declare(strict_types=1);

namespace NullDev\Skeleton\PhpSpec\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\Method;

class InitializableMethod implements Method
{
    private $shouldHaveTypes;

    public function __construct(array $shouldHaveTypes)
    {
        $this->shouldHaveTypes = $shouldHaveTypes;
    }

    public function getShouldHaveTypes(): array
    {
        return $this->shouldHaveTypes;
    }

    public function getVisibility(): string
    {
        return 'public';
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function getMethodName(): string
    {
        return 'it_is_initializable';
    }

    public function getMethodParameters(): array
    {
        return [];
    }

    public function hasMethodReturnType(): bool
    {
        return false;
    }

    public function getMethodReturnType(): string
    {
        throw new \Exception('Err 543545: PhpSpec InitializableMethod doesnt use return types.');
    }
}
