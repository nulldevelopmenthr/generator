<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\Output\PHP;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SpecGenerator\SpecGenerator;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BroadwaySpecGeneratorTest extends BaseCodeGeneratorTest
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
