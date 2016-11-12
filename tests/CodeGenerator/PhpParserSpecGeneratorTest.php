<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\CodeGenerator;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SpecGenerator\SpecGenerator;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PhpParserSpecGeneratorTest extends BaseCodeGeneratorTest
{
    /**
     * @test
     * @dataProvider provideTestRenderData
     */
    public function outputClass(ImprovedClassSource $classSource, string $outputName)
    {
        $generator = PhpParserGeneratorFactory::create();

        $specGenerator = new SpecGenerator(new ClassSourceFactory());

        $specSource = $specGenerator->generate($classSource);

        $this->assertSame($this->getFileContent($outputName), $generator->getOutput($specSource));
    }

    public function provideTestRenderData()
    {
        return [
            [new ImprovedClassSource($this->provideClassType()), 'spec/class-spec'],
            [$this->provideSourceWithParent(), 'spec/class-with-parent-spec'],
            [$this->provideSourceWithInterface(), 'spec/class-with-interface-spec'],
            [$this->provideSourceWithTrait(), 'spec/class-with-trait-spec'],
            [$this->provideSourceWithAll(), 'spec/class-with-all-spec'],
            [$this->provideSourceWithAllMulti(), 'spec/class-with-all-multi-spec'],
            [$this->provideSourceWithOneParamConstructor(), 'spec/class-with-all-1-param-spec'],
            [$this->provideSourceWithTwoParamConstructor(), 'spec/class-with-all-2-param-spec'],
            [$this->provideSourceWithThreeParamConstructor(), 'spec/class-with-all-3-param-spec'],
            [$this->provideSourceWithOneClasslessParamConstructor(), 'spec/class-with-all-1-classless-param-spec'],
            [$this->provideSourceWithOneTypeDeclarationParamConstructor(), 'spec/class-with-all-1-scalartypes-param-spec'],
        ];
    }
}
