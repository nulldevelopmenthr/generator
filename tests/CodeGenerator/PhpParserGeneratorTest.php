<?php

declare (strict_types = 1);
namespace tests\NullDev\Skeleton\Output\PHP;

use Mockery as m;
use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpParser\Node;
use PhpParser\PrettyPrinter;

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
            [$this->provideSourceForBroadwayReadEntity(), 'broadway-read-entity'],
            [$this->provideSourceForBroadwayReadRepository(), 'broadway-read-repository'],
            [$this->provideSourceForBroadwayReadProjector(), 'broadway-read-projector'],

        ];
    }
}
