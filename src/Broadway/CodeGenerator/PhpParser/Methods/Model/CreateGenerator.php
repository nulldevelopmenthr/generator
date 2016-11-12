<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\CodeGenerator\PhpParser\Methods\Model;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\CreateMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use PhpParser\BuilderFactory;

class CreateGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(CreateMethod $method)
    {
        $createMethod = $this->builderFactory
            ->method($method->getMethodName())
            ->makePublic()
            ->makeStatic()
            ->setReturnType($method->getMethodReturnType());

        foreach ($method->getMethodParameters() as $param) {
            $createMethod->addParam($this->createMethodParam($param));
        }

        return $createMethod;
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
