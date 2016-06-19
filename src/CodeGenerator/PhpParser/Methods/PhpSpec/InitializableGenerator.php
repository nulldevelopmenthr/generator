<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\CodeGenerator\PhpParser\Methods\PhpSpec;

use NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\InitializableMethod;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;

class InitializableGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(InitializableMethod $method)
    {
        $node = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic();

        foreach ($method->getShouldHaveTypes() as $classType) {
            $node->addStmt(
                new MethodCall(
                    new Variable('this'),
                    'shouldHaveType',
                    [
                        new ClassConstFetch(
                            new Name($classType->getName()),
                            'class'
                        ),
                    ]
                )
            );
        }

        return $node;
    }
}
