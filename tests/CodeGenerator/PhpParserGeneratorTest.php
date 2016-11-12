<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\CodeGenerator;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PhpParserGeneratorTest extends BaseCodeGeneratorTest
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
            [new ImprovedClassSource($this->provideClassType()), 'code/class'],
            [$this->provideSourceWithParent(), 'code/class-with-parent'],
            [$this->provideSourceWithInterface(), 'code/class-with-interface'],
            [$this->provideSourceWithTrait(), 'code/class-with-trait'],
            [$this->provideSourceWithAll(), 'code/class-with-all'],
            [$this->provideSourceWithAllMulti(), 'code/class-with-all-multi'],
            [$this->provideSourceWithOneParamConstructor(), 'code/class-with-all-1-param'],
            [$this->provideSourceWithTwoParamConstructor(), 'code/class-with-all-2-param'],
            [$this->provideSourceWithThreeParamConstructor(), 'code/class-with-all-3-param'],
            [$this->provideSourceWithOneClasslessParamConstructor(), 'code/class-with-all-1-classless-param'],
            [$this->provideSourceWithOneTypeDeclarationParamConstructor(), 'code/class-with-all-1-scalartypes-param'],
        ];
    }
}
