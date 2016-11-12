<?php

declare(strict_types=1);

namespace tests\NullDev\Skeleton\Broadway\CodeGenerator;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;

/**
 * @group  FullCoverage
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BroadwayGeneratorTest extends BaseCodeGeneratorTest
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
            [$this->provideSourceForUuidIdentifier(), 'broadway-code/uuid-identifier'],
            [$this->provideSourceForBroadwayCommand(), 'broadway-code/broadway-command'],
            [$this->provideSourceForBroadwayEvent(), 'broadway-code/broadway-event'],
            [$this->provideSourceForBroadwayModel(), 'broadway-code/broadway-model'],
            [$this->provideSourceForBroadwayModelRepository(), 'broadway-code/broadway-model-repository'],
            [$this->provideSourceForBroadwayReadEntity(), 'broadway-code/read/elasticsearch/entity'],
            [$this->provideSourceForBroadwayReadRepository(), 'broadway-code/read/elasticsearch/repository'],
            [$this->provideSourceForBroadwayReadProjector(), 'broadway-code/read/elasticsearch/projector'],

        ];
    }
}
