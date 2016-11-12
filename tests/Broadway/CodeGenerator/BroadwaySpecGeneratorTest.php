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
            [$this->provideUuidIdentifier(), 'spec/uuid-identifier-spec'],
            [$this->provideBroadwayCommand(), 'spec/broadway-command-spec'],
            [$this->provideBroadwayEvent(), 'spec/broadway-event-spec'],
            [$this->provideBroadwayModel(), 'spec/broadway-model-spec'],
            [$this->provideBroadwayModelRepository(), 'spec/broadway-model-repository-spec'],
            [$this->provideBroadwayElasticSearchReadEntity(), 'spec/read/elasticsearch/entity-spec'],
            [$this->provideBroadwayElasticSearchReadRepository(), 'spec/read/elasticsearch/repository-spec'],
            [$this->provideBroadwayElasticSearchReadProjector(), 'spec/read/elasticsearch/projector-spec'],
            [$this->provideBroadwayDoctrineOrmReadEntity(), 'spec/read/doctrine-orm/entity-spec'],
            [$this->provideBroadwayDoctrineOrmReadFactory(), 'spec/read/doctrine-orm/factory-spec'],
            [$this->provideBroadwayDoctrineOrmReadRepository(), 'spec/read/doctrine-orm/repository-spec'],
            [$this->provideBroadwayDoctrineOrmReadProjector(), 'spec/read/doctrine-orm/projector-spec'],
        ];
    }
}
