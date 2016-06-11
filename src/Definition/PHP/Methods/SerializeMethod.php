<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Definition\PHP\Methods;

class SerializeMethod implements Method
{
    private $properties;

    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getProperties() : array
    {
        return $this->properties;
    }

    public function getVisibility() : string
    {
        return 'public';
    }

    public function isStatic() : bool
    {
        return false;
    }

    public function getMethodName() : string
    {
        return 'serialize';
    }

    public function getMethodParameters() : array
    {
        return [];
    }

    public function hasMethodReturnType() : bool
    {
        return true;
    }

    public function getMethodReturnType() : string
    {
        return 'array';
    }
}
