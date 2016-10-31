<?php

declare(strict_types=1);

namespace NullDev\Skeleton\SourceFactory\Broadway;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\SourceFactory\SourceFactory;

class ReadProjectorSourceFactory implements SourceFactory
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

        //Adds Projector as parent.
        $source->addParent(ClassType::create('Broadway\ReadModel\Projector'));
        $source->addConstructorMethod($this->definitionFactory->createConstructorMethod($parameters));

        return $source;
    }
}
