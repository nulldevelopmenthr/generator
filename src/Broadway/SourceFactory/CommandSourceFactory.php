<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\SourceFactory;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\SourceFactory\SourceFactory;

class CommandSourceFactory implements SourceFactory
{
    /** @var ClassSourceFactory */
    private $sourceFactory;
    /** @var DefinitionFactory */
    private $definitionFactory;

    public function __construct(ClassSourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->sourceFactory     = $sourceFactory;
        $this->definitionFactory = $definitionFactory;
    }

    public function create(ClassType $classType, array $parameters)
    {
        $source = $this->sourceFactory->create($classType);

        //Add constructor method.
        $source->addConstructorMethod($this->definitionFactory->createConstructorMethod($parameters));

        return $source;
    }
}
