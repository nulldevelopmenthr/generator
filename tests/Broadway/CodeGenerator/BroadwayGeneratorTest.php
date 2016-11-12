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
            [$this->provideUuidIdentifier(), 'broadway-code/uuid-identifier'],
            [$this->provideBroadwayCommand(), 'broadway-code/broadway-command'],
            [$this->provideBroadwayEvent(), 'broadway-code/broadway-event'],
            [$this->provideBroadwayModel(), 'broadway-code/broadway-model'],
            [$this->provideBroadwayModelRepository(), 'broadway-code/broadway-model-repository'],
            [$this->provideBroadwayReadEntity(), 'broadway-code/read/elasticsearch/entity'],
            [$this->provideBroadwayReadRepository(), 'broadway-code/read/elasticsearch/repository'],
            [$this->provideBroadwayReadProjector(), 'broadway-code/read/elasticsearch/projector'],

        ];
    }
}
