<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Broadway\SourceFactory\Read\DoctrineOrm;

use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\SourceFactory\SourceFactory;

class ReadEntitySourceFactory implements SourceFactory
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
        //Adds Broadway Identifiable.
        $source->addInterface(InterfaceType::create(Identifiable::class));
        //Adds Broadway Serializable.
        $source->addInterface(InterfaceType::create(Serializable::class));
        //Adds serialize() method.
        $source->addMethod($this->definitionFactory->createSerializeMethod($source));
        //Adds static deserialize() method.
        $source->addMethod($this->definitionFactory->createDeserializeMethod($source));
        $source->addMethod($this->definitionFactory->createReadModelIdGetterMethod($parameters[0]));

        return $source;
    }
}
