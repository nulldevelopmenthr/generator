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
            [$this->provideUuidIdentifier(), 'code/uuid-identifier'],
            [$this->provideBroadwayCommand(), 'code/broadway-command'],
            [$this->provideBroadwayEvent(), 'code/broadway-event'],
            [$this->provideBroadwayModel(), 'code/broadway-model'],
            [$this->provideBroadwayModelRepository(), 'code/broadway-model-repository'],
            [$this->provideBroadwayReadEntity(), 'code/read/elasticsearch/entity'],
            [$this->provideBroadwayReadRepository(), 'code/read/elasticsearch/repository'],
            [$this->provideBroadwayReadProjector(), 'code/read/elasticsearch/projector'],

        ];
    }
}
