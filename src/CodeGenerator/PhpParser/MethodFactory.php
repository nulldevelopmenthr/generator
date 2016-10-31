<?php

declare(strict_types=1);

namespace NullDev\Skeleton\CodeGenerator\PhpParser;

use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\AggregateRootIdGetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\CreateGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\ReadModelIdGetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\Broadway\Model\RepositoryConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec\InitializableGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec\LetGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\UuidCreateGenerator;
use NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\AggregateRootIdGetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\CreateMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\ReadModelIdGetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\DeserializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\GetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\InitializableMethod;
use NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\LetMethod;
use NullDev\Skeleton\Definition\PHP\Methods\SerializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use PhpParser\Node;
use PhpParser\Node\Name;

/**
 * @see MethodFactorySpec
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
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
    /** @var CreateGenerator */
    private $createGenerator;
    /** @var AggregateRootIdGetterGenerator */
    private $aggregateRootIdGetterGenerator;
    /** @var RepositoryConstructorGenerator */
    private $repositoryConstructorGenerator;
    /** @var ReadModelIdGetterGenerator */
    private $readModelIdGetterGenerator;
    /** @var LetGenerator */
    private $letGenerator;
    /** @var InitializableGenerator */
    private $initializableGenerator;

    public function __construct(
        ConstructorGenerator $constructorGenerator,
        DeserializeGenerator $deserializeGenerator,
        GetterGenerator $getterGenerator,
        SerializeGenerator $serializeGenerator,
        ToStringGenerator $toStringGenerator,
        UuidCreateGenerator $uuidCreateGenerator,
        CreateGenerator $createGenerator,
        AggregateRootIdGetterGenerator $aggregateRootIdGetterGenerator,
        RepositoryConstructorGenerator $repositoryConstructorGenerator,
        ReadModelIdGetterGenerator $readModelIdGetterGenerator,
        LetGenerator $letGenerator,
        InitializableGenerator $initializableGenerator
    ) {
        $this->constructorGenerator           = $constructorGenerator;
        $this->deserializeGenerator           = $deserializeGenerator;
        $this->getterGenerator                = $getterGenerator;
        $this->serializeGenerator             = $serializeGenerator;
        $this->toStringGenerator              = $toStringGenerator;
        $this->uuidCreateGenerator            = $uuidCreateGenerator;
        $this->createGenerator                = $createGenerator;
        $this->aggregateRootIdGetterGenerator = $aggregateRootIdGetterGenerator;
        $this->repositoryConstructorGenerator = $repositoryConstructorGenerator;
        $this->readModelIdGetterGenerator     = $readModelIdGetterGenerator;
        $this->letGenerator                   = $letGenerator;
        $this->initializableGenerator         = $initializableGenerator;
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
        } elseif ($method instanceof CreateMethod) {
            return $this->createGenerator->generate($method);
        } elseif ($method instanceof AggregateRootIdGetterMethod) {
            return $this->aggregateRootIdGetterGenerator->generate($method);
        } elseif ($method instanceof RepositoryConstructorMethod) {
            return $this->repositoryConstructorGenerator->generate($method);
        } elseif ($method instanceof ReadModelIdGetterMethod) {
            return $this->readModelIdGetterGenerator->generate($method);
        } elseif ($method instanceof LetMethod) {
            return $this->letGenerator->generate($method);
        } elseif ($method instanceof InitializableMethod) {
            return $this->initializableGenerator->generate($method);
        } else {
            throw new \Exception('ERR 12431999: Unhandled method:'.get_class($method));
        }
    }
}
