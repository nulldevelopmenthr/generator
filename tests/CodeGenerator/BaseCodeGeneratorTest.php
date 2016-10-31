<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\Output\PHP;

use Mockery as m;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\IntType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\Broadway\CommandSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourcedAggregateRootSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourcingRepositorySourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\ReadEntitySourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\ReadProjectorSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\ReadRepositorySourceFactory;
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class BaseCodeGeneratorTest extends \PHPUnit_Framework_TestCase
{
    protected function provideSourceWithParent() : ImprovedClassSource
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addParent($this->provideParentClassType());
    }

    protected function provideSourceWithInterface() : ImprovedClassSource
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addInterface($this->provideInterfaceType1());
    }

    protected function provideSourceWithTrait() : ImprovedClassSource
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addTrait($this->provideTraitType1());
    }

    protected function provideSourceWithAll() : ImprovedClassSource
    {
        return $this->provideSourceWithParent()
            ->addInterface($this->provideInterfaceType1())
            ->addTrait($this->provideTraitType1());
    }

    protected function provideSourceWithAllMulti() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()
            ->addInterface($this->provideInterfaceType2())
            ->addTrait($this->provideTraitType2());
    }

    protected function provideSourceWithOneParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1Parameters());
    }

    protected function provideSourceWithTwoParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith2Parameters());
    }

    protected function provideSourceWithThreeParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith3Parameters());
    }

    protected function provideSourceWithOneClasslessParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1ClasslessParameters());
    }

    protected function provideSourceWithOneTypeDeclarationParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()
            ->addConstructorMethod($this->provideConstructorWith1ScalarTypesParameters());
    }

    protected function provideConstructorWith1Parameters() : ConstructorMethod
    {
        return new ConstructorMethod([new Parameter('firstName', new ClassType('FirstName'))]);
    }

    protected function provideConstructorWith1ClasslessParameters() : ConstructorMethod
    {
        return new ConstructorMethod([new Parameter('firstName')]);
    }

    protected function provideConstructorWith1ScalarTypesParameters() : ConstructorMethod
    {
        return new ConstructorMethod([new Parameter('firstName', new StringType())]);
    }

    protected function provideConstructorWith2Parameters() : ConstructorMethod
    {
        $params = [
            new Parameter('firstName', new ClassType('FirstName')),
            new Parameter('lastName', new ClassType('LastName')),
        ];

        return new ConstructorMethod($params);
    }

    protected function provideConstructorWith3Parameters() : ConstructorMethod
    {
        $params = [
            new Parameter('firstName', new ClassType('FirstName')),
            new Parameter('lastName', new ClassType('LastName')),
            new Parameter('amount', new ClassType('Wage', 'HR\\Finances')),
        ];

        return new ConstructorMethod($params);
    }

    protected function provideSourceForUuidIdentifier() : ImprovedClassSource
    {
        $classType = new ClassType('SomeClass', 'SomeNamespace');

        $factory = new UuidIdentitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    protected function provideSourceForBroadwayCommand() : ImprovedClassSource
    {
        $classType  = new ClassType('CreateProduct', 'MyShop\\Command');
        $parameters = [
            new Parameter('productId', ClassType::create('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
        ];

        $factory = new CommandSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideSourceForBroadwayEvent() : ImprovedClassSource
    {
        $classType  = new ClassType('ProductCreated', 'MyShop\\Event');
        $parameters = [
            new Parameter('productId', ClassType::create('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create('DateTime')),
        ];

        $factory = new EventSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideSourceForBroadwayModel() : ImprovedClassSource
    {
        $classType = new ClassType('ProductModel', 'MyShop\\Model');
        $parameter = new Parameter('productId', ClassType::create('MyShop\\Model\\ProductUuid'));

        $factory = new EventSourcedAggregateRootSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameter);
    }

    protected function provideSourceForBroadwayModelRepository() : ImprovedClassSource
    {
        $classType      = ClassType::create('MyShop\\Model\\ProductModelRepository');
        $modelClassType = ClassType::create('MyShop\\Model\\ProductModel');

        $factory = new EventSourcingRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $modelClassType);
    }

    protected function provideSourceForBroadwayReadEntity() : ImprovedClassSource
    {
        $classType  = new ClassType('ProductReadEntity', 'MyShop\\ReadModel\\Product');
        $parameters = [
            new Parameter('productId', ClassType::create('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create('DateTime')),
        ];

        $factory = new ReadEntitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideSourceForBroadwayReadRepository() : ImprovedClassSource
    {
        $classType = new ClassType('ProductReadRepository', 'MyShop\\ReadModel\\Product');

        $factory = new ReadRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    protected function provideSourceForBroadwayReadProjector() : ImprovedClassSource
    {
        $classType  = new ClassType('ProductReadProjector', 'MyShop\\ReadModel\\Product');
        $parameters = [
            new Parameter('repository', ClassType::create('MyShop\\ReadModel\\Product\\ProductReadRepository')),
        ];
        $factory = new ReadProjectorSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    protected function provideClassType() : ClassType
    {
        return new ClassType('Senior', 'Developer');
    }

    protected function provideParentClassType() : ClassType
    {
        return new ClassType('Person', 'Human');
    }

    protected function provideInterfaceType1() : InterfaceType
    {
        return new InterfaceType('Coder');
    }

    protected function provideInterfaceType2() : InterfaceType
    {
        return new InterfaceType('Coder2');
    }

    protected function provideTraitType1() : TraitType
    {
        return new TraitType('SomeTrait');
    }

    protected function provideTraitType2() : TraitType
    {
        return new TraitType('SomeTrait2');
    }

    protected function getFileContent(string $fileName) : string
    {
        return file_get_contents(__DIR__.'/sample-files/'.$fileName.'.output');
    }
}
