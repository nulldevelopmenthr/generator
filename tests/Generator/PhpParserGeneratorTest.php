<?php

declare (strict_types = 1);
namespace tests\NullDev\Skeleton\Output\PHP;

use Mockery as m;
use NullDev\Skeleton\Definition\PHP\Methods\Constructor;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\IntType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType;
use NullDev\Skeleton\Generator\PhpParser\ClassGenerator;
use NullDev\Skeleton\Generator\PhpParser\MethodFactory;
use NullDev\Skeleton\Generator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\UuidCreateGenerator;
use NullDev\Skeleton\Generator\PhpParserGenerator;
use NullDev\Skeleton\Popular\Broadway\CommandFactory;
use NullDev\Skeleton\Popular\Broadway\EventFactory;
use NullDev\Skeleton\Popular\UuidFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\ParserFactory;
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
        $generator = new PhpParserGenerator(
            new BuilderFactory(),
            new ClassGenerator(
                new BuilderFactory()
            ),
            new MethodFactory(
                new ConstructorGenerator(new BuilderFactory()),
                new DeserializeGenerator(new BuilderFactory()),
                new GetterGenerator(new BuilderFactory()),
                new SerializeGenerator(new BuilderFactory()),
                new ToStringGenerator(new BuilderFactory()),
                new UuidCreateGenerator(new BuilderFactory())
            ),
            new PrettyPrinter\Standard(),
            $classSource
        );

        $this->assertSame($this->getFileContent($outputName), $generator->getOutput());
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

        ];
    }

    public function provideSourceWithParent()
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addParent($this->provideParentClassType());
    }

    public function provideSourceWithInterface()
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addInterface($this->provideInterfaceType1());
    }

    public function provideSourceWithTrait()
    {
        $source = new ImprovedClassSource($this->provideClassType());

        return $source->addTrait($this->provideTraitType1());
    }

    public function provideSourceWithAll()
    {
        return $this->provideSourceWithParent()
            ->addInterface($this->provideInterfaceType1())
            ->addTrait($this->provideTraitType1());
    }

    public function provideSourceWithAllMulti()
    {
        return $this->provideSourceWithAll()
            ->addInterface($this->provideInterfaceType2())
            ->addTrait($this->provideTraitType2());
    }

    public function provideSourceWithOneParamConstructor()
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1Parameters());
    }

    public function provideSourceWithTwoParamConstructor()
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith2Parameters());
    }

    public function provideSourceWithThreeParamConstructor()
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith3Parameters());
    }

    public function provideSourceWithOneClasslessParamConstructor()
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1ClasslessParameters());
    }

    public function provideSourceWithOneTypeDeclarationParamConstructor()
    {
        return $this->provideSourceWithAll()->addConstructorMethod($this->provideConstructorWith1ScalarTypesParameters());
    }

    private function provideConstructorWith1Parameters()
    {
        return new ConstructorMethod([new Parameter('firstName', new ClassType('FirstName'))]);
    }

    private function provideConstructorWith1ClasslessParameters()
    {
        return new ConstructorMethod([new Parameter('firstName')]);
    }

    protected function provideConstructorWith1ScalarTypesParameters()
    {
        return new ConstructorMethod([new Parameter('firstName', new StringType())]);
    }

    private function provideConstructorWith2Parameters()
    {
        $params = [
            new Parameter('firstName', new ClassType('FirstName')),
            new Parameter('lastName', new ClassType('LastName')),
        ];

        return new ConstructorMethod($params);
    }

    private function provideConstructorWith3Parameters()
    {
        $params = [
            new Parameter('firstName', new ClassType('FirstName')),
            new Parameter('lastName', new ClassType('LastName')),
            new Parameter('amount', new ClassType('Wage', 'HR\\Finances')),
        ];

        return new ConstructorMethod($params);
    }

    private function provideSourceForUuidIdentifier()
    {
        $className   = new ClassType('SomeClass', 'SomeNamespace');
        $uuidFactory = new UuidFactory($className);

        return $uuidFactory->getSource();
    }

    private function provideSourceForBroadwayCommand()
    {
        $className  = new ClassType('CreateProduct', 'MyShop\\Command');
        $parameters = [
            new Parameter('productId', ClassType::createFromFullyQualified('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
        ];

        $factory = new CommandFactory($className, $parameters);

        return $factory->getSource();
    }

    private function provideSourceForBroadwayEvent()
    {
        $className  = new ClassType('ProductCreated', 'MyShop\\Event');
        $parameters = [
            new Parameter('productId', ClassType::createFromFullyQualified('Ramsey\\Uuid\\Uuid')),
            new Parameter('title', new StringType()),
            new Parameter('quantity', new IntType()),
            new Parameter('locationsAvailable', new ArrayType()),
            new Parameter('createdAt', ClassType::create('DateTime')),
        ];

        $factory = new EventFactory($className, $parameters);

        return $factory->getSource();
    }

    private function provideClassType()
    {
        return new ClassType('Senior', 'Developer');
    }

    private function provideParentClassType()
    {
        return new ClassType('Person', 'Human');
    }

    private function provideInterfaceType1()
    {
        return new InterfaceType('Coder');
    }

    private function provideInterfaceType2()
    {
        return new InterfaceType('Coder2');
    }

    private function provideTraitType1()
    {
        return new TraitType('SomeTrait');
    }

    private function provideTraitType2()
    {
        return new TraitType('SomeTrait2');
    }

    private function getFileContent(string $fileName)
    {
        return file_get_contents(__DIR__.'/sample-files/'.$fileName.'.output');
    }
}
