<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Popular\Broadway;

use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ImprovedClassSource;

class CommandFactory
{
    private $classType;
    private $params;
    private $source;

    public function __construct(ClassType $classType, array  $params)
    {
        $this->classType = $classType;
        $this->params    = $params;
        $this->source    = new ImprovedClassSource($classType);
        $this->run();
    }

    private function run()
    {
        $constructor = new ConstructorMethod($this->params);

        $this->source->addConstructorMethod($constructor);
    }

    public function getSource() : ImprovedClassSource
    {
        return $this->source;
    }
}
