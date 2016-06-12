<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\SourceFactory\Broadway;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\SourceFactory;

class EventSourceFactory
{
    /** @var SourceFactory */
    private $sourceFactory;
    /** @var DefinitionFactory */
    private $definitionFactory;

    public function __construct(SourceFactory $sourceFactory, DefinitionFactory $definitionFactory)
    {
        $this->sourceFactory     = $sourceFactory;
        $this->definitionFactory = $definitionFactory;
    }

    public function create(ClassType $classType, array $parameters)
    {
        $source = $this->sourceFactory->create($classType);

        //Add constructor method.
        $source->addConstructorMethod($this->definitionFactory->createConstructorMethod($parameters));
        //Adds Broadway SerializableInterface.
        $source->addInterface(InterfaceType::create('Broadway\Serializer\SerializableInterface'));
        //Adds serialize() method.
        $source->addMethod($this->definitionFactory->createSerializeMethod($source));
        //Adds static deserialize() method.
        $source->addMethod($this->definitionFactory->createDeserializeMethod($source));

        return $source;
    }
}
