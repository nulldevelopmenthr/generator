<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Definition\PHP\Methods;

use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;

class DeserializeMethod implements Method
{
    private $classType;
    private $properties;

    public function __construct(ClassType $classType, array $properties)
    {
        $this->classType  = $classType;
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
        return true;
    }

    public function getMethodName() : string
    {
        return 'deserialize';
    }

    public function getMethodParameters() : array
    {
        return [new Parameter('data', new ArrayType())];
    }

    public function hasMethodReturnType() : bool
    {
        return true;
    }

    public function getMethodReturnType() : string
    {
        return $this->classType->getName();
    }
}
