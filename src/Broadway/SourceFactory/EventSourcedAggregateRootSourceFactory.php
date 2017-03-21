<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\SourceFactory;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;

class EventSourcedAggregateRootSourceFactory
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

    public function create(ClassType $classType, Parameter $parameter)
    {
        $source = $this->sourceFactory->create($classType);

        $source->addParent(ClassType::create(EventSourcedAggregateRoot::class));

        //Add aggregate root id as property.
        $source->addProperty($parameter);
        $source->addImport($parameter->getClassType());
        //Add static create() method.
        $source->addMethod($this->definitionFactory->createBroadwayModelCreateMethod($classType, [$parameter]));
        //Add aggregate root id getter.
        $source->addMethod(
            $this->definitionFactory->createBroadwayModelAggregateRootIdGetterMethod($parameter)
        );

        return $source;
    }
}
