<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\Output\PHP;

use Mockery as m;
use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SpecGenerator\SpecGenerator;
use PhpParser\Node;
use PhpParser\PrettyPrinter;

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
            [$this->provideSourceForUuidIdentifier(), 'broadway-spec/uuid-identifier-spec'],
            [$this->provideSourceForBroadwayCommand(), 'broadway-spec/broadway-command-spec'],
            [$this->provideSourceForBroadwayEvent(), 'broadway-spec/broadway-event-spec'],
            [$this->provideSourceForBroadwayModel(), 'broadway-spec/broadway-model-spec'],
            [$this->provideSourceForBroadwayModelRepository(), 'broadway-spec/broadway-model-repository-spec'],
            [$this->provideSourceForBroadwayReadEntity(), 'broadway-spec/broadway-read-entity-spec'],
            [$this->provideSourceForBroadwayReadRepository(), 'broadway-spec/broadway-read-repository-spec'],
            [$this->provideSourceForBroadwayReadProjector(), 'broadway-spec/broadway-read-projector-spec'],
        ];
    }
}
