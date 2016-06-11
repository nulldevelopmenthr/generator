<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Generator\PhpParser;

use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\DeserializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\GetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Methods\SerializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Generator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\UuidCreateGenerator;
use PhpParser\Node;
use PhpParser\Node\Name;

/**
 * @see MethodFactorySpec
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MethodFactory
{
    /** @var ConstructorGenerator */
    private $constructorGenerator;
    /** @var DeserializeGenerator */
    private $deserializeGenerator;
    /** @var GetterGenerator */
    private $getterGenerator;
    /** @var SerializeGenerator */
    private $serializeGenerator;
    /** @var ToStringGenerator */
    private $toStringGenerator;
    /** @var UuidCreateGenerator */
    private $uuidCreateGenerator;

    public function __construct(
        ConstructorGenerator $constructorGenerator,
        DeserializeGenerator $deserializeGenerator,
        GetterGenerator $getterGenerator,
        SerializeGenerator $serializeGenerator,
        ToStringGenerator $toStringGenerator,
        UuidCreateGenerator $uuidCreateGenerator
    ) {
        $this->constructorGenerator = $constructorGenerator;
        $this->deserializeGenerator = $deserializeGenerator;
        $this->getterGenerator      = $getterGenerator;
        $this->serializeGenerator   = $serializeGenerator;
        $this->toStringGenerator    = $toStringGenerator;
        $this->uuidCreateGenerator  = $uuidCreateGenerator;
    }

    public function generate(Method $method)
    {
        if ($method instanceof ConstructorMethod) {
            return $this->constructorGenerator->generate($method);
        } elseif ($method instanceof GetterMethod) {
            return $this->getterGenerator->generate($method);
        } elseif ($method instanceof ToStringMethod) {
            return $this->toStringGenerator->generate($method);
        } elseif ($method instanceof UuidCreateMethod) {
            return $this->uuidCreateGenerator->generate($method);
        } elseif ($method instanceof SerializeMethod) {
            return $this->serializeGenerator->generate($method);
        } elseif ($method instanceof DeserializeMethod) {
            return $this->deserializeGenerator->generate($method);
        } else {
            throw new \Exception('ERR 12431999: Unhandled method:'.get_class($method));
        }
    }
}
