<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\Broadway\SourceFactory\Read\ElasticSearch\ReadEntitySourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\Read\ElasticSearch\ReadProjectorSourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\Read\ElasticSearch\ReadRepositorySourceFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\Exception\Example\PendingException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class BroadwayElasticSearchReadCliCommand extends BaseSkeletonGeneratorCommand
{
    protected function configure()
    {
        $this->setName('broadway:read:elastic-search')
            ->setDescription('Generates Broadway read using ElasticSearch engine')
            ->addOption('className', null, InputOption::VALUE_REQUIRED, 'Class name');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;
        $this->io     = new SymfonyStyle($input, $output);

        $this->handle();
    }

    protected function handle()
    {
        $className            = $this->handleClassNameInput();
        $readEntityProperties = $this->getConstuctorParameters();

        //Entity
        $readEntityClassType    = ClassType::create($className.'Entity');
        $readEntityClassSource  = $this->getReadEntitySource($readEntityClassType, $readEntityProperties);
        $readEntityFileResource = $this->getFileResource($readEntityClassSource);

        $this->handleGeneratingFile($readEntityFileResource);

        if ($this->io->confirm('Create PHPSpec file for Entity?', true)) {
            $readEntitySpecSource   = $this->createSpecSource($readEntityClassSource);
            $readEntitySpecResource = $this->getFileResource($readEntitySpecSource);
            $this->handleGeneratingFile($readEntitySpecResource);
        }

        //Repository
        $repositoryClassType    = ClassType::create($className.'Repository');
        $repositoryClassSource  = $this->getReadRepositorySource($repositoryClassType);
        $repositoryFileResource = $this->getFileResource($repositoryClassSource);

        $this->handleGeneratingFile($repositoryFileResource);

        if ($this->io->confirm('Create PHPSpec file for Repository?', true)) {
            $readRepositorySpecSource   = $this->createSpecSource($repositoryClassSource);
            $readRepositorySpecResource = $this->getFileResource($readRepositorySpecSource);
            $this->handleGeneratingFile($readRepositorySpecResource);
        }

        //Projector
        $readProjectorClassType    = ClassType::create($className.'Projector');
        $readProjectorClassSource  = $this->getReadProjectorSource($readProjectorClassType, $repositoryClassType);
        $readProjectorFileResource = $this->getFileResource($readProjectorClassSource);

        $this->handleGeneratingFile($readProjectorFileResource);

        if ($this->io->confirm('Create PHPSpec file for projector?', true)) {
            $readProjectorSpecSource   = $this->createSpecSource($readProjectorClassSource);
            $readProjectorSpecResource = $this->getFileResource($readProjectorSpecSource);
            $this->handleGeneratingFile($readProjectorSpecResource);
        }
    }

    private function getReadEntitySource(ClassType $readEntityClassType, array $parameters): ImprovedClassSource
    {
        $factory = new ReadEntitySourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        return $factory->create($readEntityClassType, $parameters);
    }

    private function getReadRepositorySource(ClassType $repositoryClassType): ImprovedClassSource
    {
        $factory = new ReadRepositorySourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        return $factory->create($repositoryClassType);
    }

    private function getReadProjectorSource(
        ClassType $projectorClassType,
        ClassType $repositoryClassType
    ): ImprovedClassSource {
        $factory = new ReadProjectorSourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        $parameter = new Parameter('repository', $repositoryClassType);

        return $factory->create($projectorClassType, [$parameter]);
    }

    protected function getSectionMessage(): string
    {
        return 'Generate Broadway read models';
    }

    protected function getIntroductionMessage(): array
    {
        return [
            '',
            'This command helps you generate Broadway read model.',
            '',
            'First, you need to give the class name you want to generate.',
            'IMPORTANT!: Dont add suffixes!',
        ];
    }

    protected function createGenerator()
    {
        throw new PendingException();
    }
}
