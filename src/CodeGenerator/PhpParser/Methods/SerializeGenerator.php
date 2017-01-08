<?php

declare(strict_types=1);

namespace NullDev\Skeleton\CodeGenerator\PhpParser\Methods;

use NullDev\Skeleton\Definition\PHP\Methods\SerializeMethod;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\TypeDeclaration;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Name;

class SerializeGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(SerializeMethod $method)
    {
        $serializeMethod = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic()
            ->setReturnType($method->getMethodReturnType());

        $zz = [];

        foreach ($method->getProperties() as $property) {
            if ($property->hasClass() && (!$property->getClassType() instanceof TypeDeclaration)) {
                if ($property->getClassType()->getFullName() === 'DateTime') {
                    $var =
                        new Node\Expr\MethodCall(
                            new Node\Expr\Variable('this->'.$property->getName()),
                            new Name('format'),
                            [new Node\Scalar\String_('c')]
                        );
                } else {
                    $var =
                        new Node\Expr\Cast\String_(
                            new Node\Expr\Variable('this->'.$property->getName())
                        );
                }
            } else {
                $var = new Node\Expr\Variable('this->'.$property->getName());
            }

            $zz[] = new Node\Expr\ArrayItem(
                $var,
                new Node\Scalar\String_($property->getName())
            );
        }

        $return = new Node\Stmt\Return_(
            new Node\Expr\Array_(
                $zz,
                ['kind' => Node\Expr\Array_::KIND_SHORT]
            )
        );
        $serializeMethod->addStmt($return);

        return $serializeMethod;
    }
}
