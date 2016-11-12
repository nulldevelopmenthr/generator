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
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\LetMethod;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LetGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(LetMethod $method)
    {
        $node = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic();

        $beParams = [];

        foreach ($method->getMethodParameters() as $param) {
            if ($this->isParameterEligibleForLetParameter($param)) {
                $node->addParam($this->createMethodParam($param));
                $beParams[] = new Variable($param->getName());
            } else {
                $beParams[] = $this->createBeConstructedWithArgument($param);
            }
        }

        $node->addStmt(new MethodCall(new Variable('this'), 'beConstructedWith', $beParams));

        return $node;
    }

    private function createBeConstructedWithArgument(Parameter $parameter)
    {
        $variable = new Variable($parameter->getName());

        if (false === $parameter->hasClass()) {
            return new Assign($variable, new String_($parameter->getName()));
        }

        if ($parameter->getClassType() instanceof StringType) {
            return new Assign($variable, new String_($parameter->getName()));
        } elseif ($parameter->getClassType() instanceof IntType) {
            return new Assign($variable, new LNumber(1));
        } elseif ($parameter->getClassType() instanceof ArrayType) {
            return new Assign($variable, new Array_([], ['kind' => Array_::KIND_SHORT]));
        } elseif ($parameter->getClassType() instanceof FloatType) {
            return new Assign($variable, new DNumber(2.0));
        } elseif ($parameter->getClassType() instanceof BoolType) {
            return new Assign($variable, true);
        }

        throw new \Exception('ERR 90131234: Unhandled argument received.');
    }

    private function isParameterEligibleForLetParameter(Parameter $parameter)
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

        if ($param->hasClass()) {
            $result->setTypeHint($param->getClassType()->getName());
        }

        return $result;
    }
}
