<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\AggregateRootIdGetterMethod;
use PhpParser\BuilderFactory;
use PhpParser\Node;

class AggregateRootIdGetterGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(AggregateRootIdGetterMethod $method)
    {
        $getterMethod = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic();

        if ($method->hasMethodReturnType()) {
            $getterMethod->setReturnType($method->getMethodReturnType());
        }

        $return = new Node\Stmt\Return_(
            new Node\Expr\Variable('this->'.$method->getPropertyName())
        );
        $getterMethod->addStmt($return);

        return $getterMethod;
    }
}
