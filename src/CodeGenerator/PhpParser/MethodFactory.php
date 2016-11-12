<?php

declare(strict_types=1);

namespace NullDev\Skeleton\CodeGenerator\PhpParser;

use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\AggregateRootIdGetterGenerator;
use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\CreateGenerator;
use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\ReadModelIdGetterGenerator;
use NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model\RepositoryConstructorGenerator;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\AggregateRootIdGetterMethod;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\CreateMethod;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\ReadModelIdGetterMethod;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\Methods\UuidCreateGenerator;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\DeserializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\GetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Methods\SerializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\ExposeConstructorArgumentsAsGettersGenerator;
use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\InitializableGenerator;
use NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods\LetGenerator;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\ExposeConstructorArgumentsAsGettersMethod;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\InitializableMethod;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\LetMethod;

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
    /** @var ExposeConstructorArgumentsAsGettersGenerator */
    private $exposeConstructorArgsGenerator;

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
        InitializableGenerator $initializableGenerator,
        ExposeConstructorArgumentsAsGettersGenerator $exposeConstructorArgsGenerator
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
        $this->exposeConstructorArgsGenerator = $exposeConstructorArgsGenerator;
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
        } elseif ($method instanceof ExposeConstructorArgumentsAsGettersMethod) {
            return $this->exposeConstructorArgsGenerator->generate($method);
        } else {
            throw new \Exception('ERR 12431999: Unhandled method:'.get_class($method));
        }
    }
}
