<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Definition\PHP;

use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\DeserializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\GetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\SerializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\Type;

class DefinitionFactory
{
    public function createParameter(string $name, Type $type) : Parameter
    {
        return new Parameter($name, $type);
    }

    public function createConstructorMethod(array $params) : ConstructorMethod
    {
        return new ConstructorMethod($params);
    }

    public function createDeserializeMethod(ClassType $classType, array $parameters) : DeserializeMethod
    {
        return new DeserializeMethod($classType, $parameters);
    }

    public function createGetterMethod(Parameter $parameter) : GetterMethod
    {
        return new GetterMethod($parameter);
    }

    public function createSerializeMethod(array $parameters) : SerializeMethod
    {
        return new SerializeMethod($parameters);
    }

    public function createToStringMethod(Parameter $parameter) : ToStringMethod
    {
        return new ToStringMethod($parameter);
    }

    public function createUuidCreateMethod(ClassType $classType) : UuidCreateMethod
    {
        return new UuidCreateMethod($classType);
    }
}
