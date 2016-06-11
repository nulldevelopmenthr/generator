<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Popular;

use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\ImprovedClassSource;

class UuidFactory
{
    private $classType;
    private $source;

    public function __construct(ClassType $classType)
    {
        $this->classType = $classType;
        $this->source    = new ImprovedClassSource($classType);
        $this->run();
    }

    private function run()
    {
        $param = new Parameter('id', new StringType());

        $constructor = new ConstructorMethod([$param]);

        $this->source->addConstructorMethod($constructor);
        $this->source->addMethod(new ToStringMethod($param));
        $this->source->addMethod(new UuidCreateMethod($this->classType));
        $this->source->addImport(new ClassType('Uuid', 'Ramsey\Uuid'));
    }

    public function getSource() : ImprovedClassSource
    {
        return $this->source;
    }
}
