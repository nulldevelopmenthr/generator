<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\SourceFactory\Broadway;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;

class EventSourcingRepositorySourceFactory
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

    public function create(ClassType $classType, ClassType $modelClassType)
    {
        $source = $this->sourceFactory->create($classType);

        $source->addParent(ClassType::create('Broadway\EventSourcing\EventSourcingRepository'));

        $source->addImport(
            ClassType::create('Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory')
        );
        $source->addImport(
            ClassType::create('Broadway\EventHandling\EventBusInterface')
        );
        $source->addImport(
            ClassType::create('Broadway\EventStore\EventStoreInterface')
        );

        //Add aggregate root id as property.
        //Add constructor which calls parent constructor method.
        $source->addMethod(
            $this->definitionFactory->createBroadwayModelRepositoryConstructorMethod($modelClassType)
        );

        return $source;
    }
}
