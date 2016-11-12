<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\Broadway\CodeGenerator;

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
            [$this->provideUuidIdentifier(), 'broadway-spec/uuid-identifier-spec'],
            [$this->provideBroadwayCommand(), 'broadway-spec/broadway-command-spec'],
            [$this->provideBroadwayEvent(), 'broadway-spec/broadway-event-spec'],
            [$this->provideBroadwayModel(), 'broadway-spec/broadway-model-spec'],
            [$this->provideBroadwayModelRepository(), 'broadway-spec/broadway-model-repository-spec'],
            [$this->provideBroadwayReadEntity(), 'broadway-spec/read/elasticsearch/entity-spec'],
            [$this->provideBroadwayReadRepository(), 'broadway-spec/read/elasticsearch/repository-spec'],
            [$this->provideBroadwayReadProjector(), 'broadway-spec/read/elasticsearch/projector-spec'],
        ];
    }
}
