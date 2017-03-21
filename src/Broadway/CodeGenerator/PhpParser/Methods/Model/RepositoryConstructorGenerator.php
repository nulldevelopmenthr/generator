<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model;

use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Name;

class RepositoryConstructorGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(RepositoryConstructorMethod $method)
    {
        $constructor = $this->builderFactory
            ->method('__construct')
            ->makePublic();

        $constructor->addParam(
            $this->createMethodParam(
                new Parameter('eventStore', InterfaceType::create(EventStore::class))
            )
        );

        $constructor->addParam(
            $this->createMethodParam(
                new Parameter('eventBus', InterfaceType::create(EventBus::class))
            )
        );
        $constructor->addParam(
            $this->createMethodParamWithDefaultValue(
                new Parameter('eventStreamDecorators', new ArrayType()),
                []
            )
        );

        $constructor->addStmt(
            new Node\Expr\StaticCall(
                new Name('parent'),
                '__construct',
                [
                    new Node\Expr\Variable('eventStore'),
                    new Node\Expr\Variable('eventBus'),
                    new Name($method->getModelClassType()->getName().'::class'),
                    new Node\Expr\New_(new Name('PublicConstructorAggregateFactory')),
                    new Node\Expr\Variable('eventStreamDecorators'),
                ]
            )
        );

        return $constructor;
    }

    private function createMethodParam(Parameter $param)
    {
        $result = $this->builderFactory->param($param->getName());

        if ($param->hasClass()) {
            $result->setTypeHint($param->getClassType()->getName());
        }

        return $result;
    }

    private function createMethodParamWithDefaultValue(Parameter $param, $defaultValue)
    {
        $result = $this->builderFactory->param($param->getName());

        if ($param->hasClass()) {
            $result->setTypeHint($param->getClassType()->getName());
        }

        $result->setDefault($defaultValue);

        return $result;
    }
}
