<?php

declare(strict_types=1);

namespace NullDev\Skeleton\PhpSpec\CodeGenerator\PhpParser\Methods;

use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\BoolType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\FloatType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\IntType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\TypeDeclaration;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\ExposeConstructorArgumentsAsGettersMethod;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;

/**
 * @see ExposeConstructorArgumentsAsGettersGeneratorSpec
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ExposeConstructorArgumentsAsGettersGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(ExposeConstructorArgumentsAsGettersMethod $method)
    {
        $node = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic();

        foreach ($method->getMethodParameters() as $param) {
            if ($this->isParameterEligibleForMethodParameter($param)) {
                $node->addParam($this->createMethodParam($param));
            }
        }

        foreach ($method->getMethodParameters() as $param) {
            if ($this->isParameterEligibleForMethodParameter($param)) {
                $node->addStmt(
                    new MethodCall(
                        new MethodCall(
                            new Variable('this'),
                            'get'.ucfirst($param->getName())
                        ),
                        'shouldReturn',
                        [new Variable($param->getName())]
                    )
                );
            } else {
                $node->addStmt(
                    new MethodCall(
                        new MethodCall(
                            new Variable('this'),
                            'get'.ucfirst($param->getName())
                        ),
                        'shouldReturn',
                        [$this->createShouldReturn($param)]
                    )
                );
            }
        }

        return $node;
    }

    private function createShouldReturn(Parameter $parameter)
    {
        if (false === $parameter->hasClass()) {
            return new String_($parameter->getName());
        }

        if ($parameter->getClassType() instanceof StringType) {
            return new String_($parameter->getName());
        } elseif ($parameter->getClassType() instanceof IntType) {
            return new LNumber(1);
        } elseif ($parameter->getClassType() instanceof ArrayType) {
            return new Array_([], ['kind' => Array_::KIND_SHORT]);
        } elseif ($parameter->getClassType() instanceof FloatType) {
            return new DNumber(2.0);
        } elseif ($parameter->getClassType() instanceof BoolType) {
            return true;
        }

        throw new \Exception('ERR 242342123123: Unhandled argument received.');
    }

    private function isParameterEligibleForMethodParameter(Parameter $parameter)
    {
        if (false === $parameter->hasClass()) {
            return false;
        }

        if ($parameter->getClassType() instanceof TypeDeclaration) {
            return false;
        }

        return true;
    }

    private function createMethodParam(Parameter $param)
    {
        $result = $this->builderFactory->param($param->getName());

        return $result;
    }
}
