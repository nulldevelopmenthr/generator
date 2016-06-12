<?php

declare (strict_types = 1);
namespace tests\NullDev\Skeleton\Output\PHP;

use Mockery as m;
use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
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
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PhpParserGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideTestRenderData
     */
    public function outputClass(ImprovedClassSource $classSource, string $outputName)
    {
        $generator = PhpParserGeneratorFactory::create();

        $this->assertSame($this->getFileContent($outputName), $generator->getOutput($classSource));
    }

    public function provideTestRenderData()
    {
        return [
            [new ImprovedClassSource($this->provideClassType()), 'class'],
            [$this->provideSourceWithParent(), 'class-with-parent'],
            [$this->provideSourceWithInterface(), 'class-with-interface'],
            [$this->provideSourceWithTrait(), 'class-with-trait'],
            [$this->provideSourceWithAll(), 'class-with-all'],
            [$this->provideSourceWithAllMulti(), 'class-with-all-multi'],
            [$this->provideSourceWithOneParamConstructor(), 'class-with-all-1-param'],
            [$this->provideSourceWithTwoParamConstructor(), 'class-with-all-2-param'],
            [$this->provideSourceWithThreeParamConstructor(), 'class-with-all-3-param'],
            [$this->provideSourceWithOneClasslessParamConstructor(), 'class-with-all-1-classless-param'],
            [$this->provideSourceWithOneTypeDeclarationParamConstructor(), 'class-with-all-1-scalartypes-param'],
            [$this->provideSourceForUuidIdentifier(), 'uuid-identifier'],
            [$this->provideSourceForBroadwayCommand(), 'broadway-command'],
            [$this->provideSourceForBroadwayEvent(), 'broadway-event'],
            [$this->provideSourceForBroadwayModel(), 'broadway-model'],
            [$this->provideSourceForBroadwayModelRepository(), 'broadway-model-repository'],

        ];
    }

    public function provideSourceWithParent() : ImprovedClassSource
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addParent($this->provideParentClassType());
    }

    public function provideSourceWithInterface() : ImprovedClassSource
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addInterface($this->provideInterfaceType1());
    }

    public function provideSourceWithTrait() : ImprovedClassSource
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addTrait($this->provideTraitType1());
    }

    public function provideSourceWithAll() : ImprovedClassSource
    {
        return $this->provideSourceWithParent()
            ->addInterface($this->provideInterfaceType1())
            ->addTrait($this->provideTraitType1());
    }

    public function provideSourceWithAllMulti() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()
            ->addInterface($this->provideInterfaceType2())
            ->addTrait($this->provideTraitType2());
    }

    public function provideSourceWithOneParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1Parameters());
    }

    public function provideSourceWithTwoParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith2Parameters());
    }

    public function provideSourceWithThreeParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith3Parameters());
    }

    public function provideSourceWithOneClasslessParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1ClasslessParameters());
    }

    public function provideSourceWithOneTypeDeclarationParamConstructor() : ImprovedClassSource
    {
        return $this->provideSourceWithAll()
            ->addConstructorMethod($this->provideConstructorWith1ScalarTypesParameters());
    }

    private function provideConstructorWith1Parameters() : ConstructorMethod
    {
        return new ConstructorMethod([new Parameter('firstName', new ClassType('FirstName'))]);
    }

    private function provideConstructorWith1ClasslessParameters() : ConstructorMethod
    {
        return new ConstructorMethod([new Parameter('firstName')]);
    }

    protected function provideConstructorWith1ScalarTypesParameters() : ConstructorMethod
    {
        return new ConstructorMethod([new Parameter('firstName', new StringType())]);
    }

    private function provideConstructorWith2Parameters() : ConstructorMethod
    {
        $params = [
            new Parameter('firstName', new ClassType('FirstName')),
            new Parameter('lastName', new ClassType('LastName')),
        ];

        return new ConstructorMethod($params);
    }

    private function provideConstructorWith3Parameters() : ConstructorMethod
    {
        $params = [
            new Parameter('firstName', new ClassType('FirstName')),
            new Parameter('lastName', new ClassType('LastName')),
            new Parameter('amount', new ClassType('Wage', 'HR\\Finances')),
        ];

        return new ConstructorMethod($params);
    }

    private function provideSourceForUuidIdentifier() : ImprovedClassSource
    {
        $classType = new ClassType('SomeClass', 'SomeNamespace');

        $factory = new UuidIdentitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
    }

    private function provideSourceForBroadwayCommand() : ImprovedClassSource
    {
        $classType  = new ClassType('CreateProduct', 'MyShop\\Command');
        $parameters = [
            new Parameter('productId', ClassType::createFromFullyQualified('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
        ];

        $factory = new CommandSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    private function provideSourceForBroadwayEvent() : ImprovedClassSource
    {
        $classType  = new ClassType('ProductCreated', 'MyShop\\Event');
        $parameters = [
            new Parameter('productId', ClassType::createFromFullyQualified('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create('DateTime')),
        ];

        $factory = new EventSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameters);
    }

    private function provideSourceForBroadwayModel() : ImprovedClassSource
    {
        $classType = new ClassType('ProductModel', 'MyShop\\Model');
        $parameter = new Parameter('productId', ClassType::createFromFullyQualified('MyShop\\Model\\ProductUuid'));

        $factory = new EventSourcedAggregateRootSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameter);
    }

    private function provideSourceForBroadwayModelRepository() : ImprovedClassSource
    {
        $classType = ClassType::create('MyShop\\Model\\ProductModelRepository');
        $parameter = new Parameter('productId', ClassType::create('MyShop\\Model\\ProductModel'));

        $factory = new EventSourcingRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $parameter);
    }

    private function provideClassType() : ClassType
    {
        return new ClassType('Senior', 'Developer');
    }

    private function provideParentClassType() : ClassType
    {
        return new ClassType('Person', 'Human');
    }

    private function provideInterfaceType1() : InterfaceType
    {
        return new InterfaceType('Coder');
    }

    private function provideInterfaceType2() : InterfaceType
    {
        return new InterfaceType('Coder2');
    }

    private function provideTraitType1() : TraitType
    {
        return new TraitType('SomeTrait');
    }

    private function provideTraitType2() : TraitType
    {
        return new TraitType('SomeTrait2');
    }

    private function getFileContent(string $fileName) : string
    {
        return file_get_contents(__DIR__.'/sample-files/'.$fileName.'.output');
    }
}
