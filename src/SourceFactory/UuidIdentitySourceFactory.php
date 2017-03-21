<?php

declare(strict_types=1);

namespace NullDev\Skeleton\SourceFactory;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use Ramsey\Uuid\Uuid;

class UuidIdentitySourceFactory implements SourceFactory
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

    public function create(ClassType $classType)
    {
        $source = $this->sourceFactory->create($classType);
        $param  = $this->definitionFactory->createParameter('id', new StringType());

        //Add constructor method.
        $source->addConstructorMethod($this->definitionFactory->createConstructorMethod([$param]));
        //Add __toString() method.
        $source->addMethod($this->definitionFactory->createToStringMethod($param));
        //Add static create() method.
        $source->addMethod($this->definitionFactory->createUuidCreateMethod($classType));
        //Add Ramsey\Uuid\Uuid to imports.
        $source->addImport(ClassType::create(Uuid::class));

        return $source;
    }
}
