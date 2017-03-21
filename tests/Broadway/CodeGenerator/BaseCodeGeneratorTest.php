<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\Broadway\CodeGenerator;

use DateTime;
use NullDev\Skeleton\Broadway\SourceFactory\CommandSourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\EventSourcedAggregateRootSourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\EventSourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\EventSourcingRepositorySourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\Read\DoctrineOrm;
use NullDev\Skeleton\Broadway\SourceFactory\Read\ElasticSearch;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\IntType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class BaseCodeGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected function provideUuidIdentifier(): ImprovedClassSource
    {
        $classType = new ClassType('SomeClass', 'SomeNamespace');

        $factory = new UuidIdentitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    protected function provideBroadwayCommand(): ImprovedClassSource
    {
        $classType  = new ClassType('CreateProduct', 'MyShop\\Command');
        $parameters = [
            new Parameter('productId', ClassType::create(Uuid::class)),
            new Parameter('title', new StringType()),
        ];

        $factory = new CommandSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideBroadwayEvent(): ImprovedClassSource
    {
        $classType  = new ClassType('ProductCreated', 'MyShop\\Event');
        $parameters = [
            new Parameter('productId', ClassType::create(Uuid::class)),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create(DateTime::class)),
        ];

        $factory = new EventSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideBroadwayModel(): ImprovedClassSource
    {
        $classType = new ClassType('ProductModel', 'MyShop\\Model');
        $parameter = new Parameter('productId', ClassType::create('MyShop\\Model\\ProductUuid'));

        $factory = new EventSourcedAggregateRootSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameter);
    }

    protected function provideBroadwayModelRepository(): ImprovedClassSource
    {
        $classType      = ClassType::create('MyShop\\Model\\ProductModelRepository');
        $modelClassType = ClassType::create('MyShop\\Model\\ProductModel');

        $factory = new EventSourcingRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $modelClassType);
    }

    protected function provideBroadwayElasticSearchReadEntity(): ImprovedClassSource
    {
        $classType  = new ClassType('ProductReadEntity', 'MyShop\\ReadModel\\Product');
        $parameters = [
            new Parameter('productId', ClassType::create(Uuid::class)),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create(DateTime::class)),
        ];

        $factory = new ElasticSearch\ReadEntitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideBroadwayElasticSearchReadRepository(): ImprovedClassSource
    {
        $classType = new ClassType('ProductReadRepository', 'MyShop\\ReadModel\\Product');

        $factory = new ElasticSearch\ReadRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    protected function provideBroadwayElasticSearchReadProjector(): ImprovedClassSource
    {
        $classType  = new ClassType('ProductReadProjector', 'MyShop\\ReadModel\\Product');
        $parameters = [
            new Parameter('repository', ClassType::create('MyShop\\ReadModel\\Product\\ProductReadRepository')),
        ];
        $factory = new ElasticSearch\ReadProjectorSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    ///
    ///--------------------------------------------------------------------------------------------------------------------
    ///

    protected function provideBroadwayDoctrineOrmReadEntity(): ImprovedClassSource
    {
        $classType  = new ClassType('ProductReadEntity', 'MyShop\\ReadModel\\Product');
        $parameters = [
            new Parameter('productId', ClassType::create(Uuid::class)),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create(DateTime::class)),
        ];

        $factory = new DoctrineOrm\ReadEntitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideBroadwayDoctrineOrmReadFactory(): ImprovedClassSource
    {
        $classType = new ClassType('ProductReadFactory', 'MyShop\\ReadModel\\Product');
        $factory   = new DoctrineOrm\ReadFactorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    protected function provideBroadwayDoctrineOrmReadRepository(): ImprovedClassSource
    {
        $classType = new ClassType('ProductReadRepository', 'MyShop\\ReadModel\\Product');

        $factory = new DoctrineOrm\ReadRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    protected function provideBroadwayDoctrineOrmReadProjector(): ImprovedClassSource
    {
        $classType  = new ClassType('ProductReadProjector', 'MyShop\\ReadModel\\Product');
        $parameters = [
            new Parameter('repository', ClassType::create('MyShop\\ReadModel\\Product\\ProductReadRepository')),
            new Parameter('factory', ClassType::create('MyShop\\ReadModel\\Product\\ProductReadFactory')),
        ];
        $factory = new DoctrineOrm\ReadProjectorSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    ///
    ///--------------------------------------------------------------------------------------------------------------------
    ///

    protected function provideClassType(): ClassType
    {
        return new ClassType('Senior', 'Developer');
    }

    protected function provideParentClassType(): ClassType
    {
        return new ClassType('Person', 'Human');
    }

    protected function provideInterfaceType1(): InterfaceType
    {
        return new InterfaceType('Coder');
    }

    protected function provideInterfaceType2(): InterfaceType
    {
        return new InterfaceType('Coder2');
    }

    protected function provideTraitType1(): TraitType
    {
        return new TraitType('SomeTrait');
    }

    protected function provideTraitType2(): TraitType
    {
        return new TraitType('SomeTrait2');
    }

    protected function getFileContent(string $fileName): string
    {
        return file_get_contents(__DIR__.'/sample-files/'.$fileName.'.output');
    }
}
