<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\ReadModelIdGetterMethod;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Expr\Cast\String_;

class ReadModelIdGetterGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(ReadModelIdGetterMethod $method)
    {
        $getterMethod = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic();

        if ($method->hasMethodReturnType()) {
            $getterMethod->setReturnType($method->getMethodReturnType());
        }

        $return = new Node\Stmt\Return_(
            new String_(
                new Node\Expr\Variable('this->'.$method->getPropertyName())
            )
        );
        $getterMethod->addStmt($return);

        return $getterMethod;
    }
}
