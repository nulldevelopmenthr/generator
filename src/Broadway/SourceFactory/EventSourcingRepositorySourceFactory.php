<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\SourceFactory;

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
            ClassType::create('Broadway\EventHandling\EventBus')
        );
        $source->addImport(
            ClassType::create('Broadway\EventStore\EventStore')
        );

        //Add aggregate root id as property.
        //Add constructor which calls parent constructor method.
        $source->addMethod(
            $this->definitionFactory->createBroadwayModelRepositoryConstructorMethod($modelClassType)
        );

        return $source;
    }
}
