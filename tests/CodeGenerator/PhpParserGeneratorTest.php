<?php

declare(strict_types=1);

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
            [$this->provideSourceForUuidIdentifier(), 'broadway-code/uuid-identifier'],
            [$this->provideSourceForBroadwayCommand(), 'broadway-code/broadway-command'],
            [$this->provideSourceForBroadwayEvent(), 'broadway-code/broadway-event'],
            [$this->provideSourceForBroadwayModel(), 'broadway-code/broadway-model'],
            [$this->provideSourceForBroadwayModelRepository(), 'broadway-code/broadway-model-repository'],
            [$this->provideSourceForBroadwayReadEntity(), 'broadway-code/broadway-read-entity'],
            [$this->provideSourceForBroadwayReadRepository(), 'broadway-code/broadway-read-repository'],
            [$this->provideSourceForBroadwayReadProjector(), 'broadway-code/broadway-read-projector'],

        ];
    }
}
