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
            [$this->provideBroadwayElasticSearchReadEntity(), 'code/read/elasticsearch/entity'],
            [$this->provideBroadwayElasticSearchReadRepository(), 'code/read/elasticsearch/repository'],
            [$this->provideBroadwayElasticSearchReadProjector(), 'code/read/elasticsearch/projector'],
            [$this->provideBroadwayDoctrineOrmReadEntity(), 'code/read/doctrine-orm/entity'],
            [$this->provideBroadwayDoctrineOrmReadFactory(), 'code/read/doctrine-orm/factory'],
            [$this->provideBroadwayDoctrineOrmReadRepository(), 'code/read/doctrine-orm/repository'],
            [$this->provideBroadwayDoctrineOrmReadProjector(), 'code/read/doctrine-orm/projector'],
        ];
    }
}
