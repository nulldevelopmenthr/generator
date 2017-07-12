<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\Broadway\SourceFactory\EventSourcedAggregateRootSourceFactory;
use NullDev\Skeleton\Broadway\SourceFactory\EventSourcingRepositorySourceFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
class BroadwayModelCliCommand extends BaseSkeletonGeneratorCommand
{
    protected function configure()
    {
        $this->setName('broadway:model')
            ->setDescription('Generates Broadway model')
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
        $className = $this->handleClassNameInput();

        //Id
        $modelIdClassType    = ClassType::create($className.'Id');
        $modelIdClassSource  = $this->getModelIdSource($modelIdClassType);
        $modelIdFileResource = $this->getFileResource($modelIdClassSource);

        $this->output->writeln('Generating Id file');
        $this->handleGeneratingFile($modelIdFileResource);

        if ($this->io->confirm('Create PHPSpec file for id?', true)) {
            $modelIdSpecSource   = $this->createSpecSource($modelIdClassSource);
            $modelIdSpecResource = $this->getFileResource($modelIdSpecSource);
            $this->handleGeneratingFile($modelIdSpecResource);
        }

        //Entity
        $modelClassType    = ClassType::create($className.'Model');
        $modelClassSource  = $this->getModelSource($modelClassType, $modelIdClassType);
        $modelFileResource = $this->getFileResource($modelClassSource);

        $this->output->writeln('Generating Model file');
        $this->handleGeneratingFile($modelFileResource);

        if ($this->io->confirm('Create PHPSpec file for Entity?', true)) {
            $modelSpecSource   = $this->createSpecSource($modelClassSource);
            $modelSpecResource = $this->getFileResource($modelSpecSource);
            $this->handleGeneratingFile($modelSpecResource);
        }

        //Repository
        $repositoryClassType    = ClassType::create($className.'Repository');
        $repositoryClassSource  = $this->getModelRepositorySource($repositoryClassType, $modelClassType);
        $repositoryFileResource = $this->getFileResource($repositoryClassSource);

        $this->output->writeln('Generating Repository file');
        $this->handleGeneratingFile($repositoryFileResource);

        if ($this->io->confirm('Create PHPSpec file for Repository?', true)) {
            $readRepositorySpecSource   = $this->createSpecSource($repositoryClassSource);
            $readRepositorySpecResource = $this->getFileResource($readRepositorySpecSource);
            $this->handleGeneratingFile($readRepositorySpecResource);
        }
    }

    private function getModelIdSource(ClassType $modelIdClassType): ImprovedClassSource
    {
        $factory = new UuidIdentitySourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        return $factory->create($modelIdClassType);
    }

    private function getModelSource(ClassType $modelClassType, ClassType $modelIdClassType): ImprovedClassSource
    {
        $factory = new EventSourcedAggregateRootSourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        $parameter = new Parameter(lcfirst($modelIdClassType->getName()), $modelIdClassType);

        return $factory->create($modelClassType, $parameter);
    }

    private function getModelRepositorySource(
        ClassType $repositoryClassType,
        ClassType $modelClassType
    ): ImprovedClassSource {
        $factory = new EventSourcingRepositorySourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        return $factory->create($repositoryClassType, $modelClassType);
    }

    protected function getSectionMessage(): string
    {
        return 'Generate Broadway model';
    }

    protected function getIntroductionMessage(): array
    {
        return [
            '',
            'This command helps you generate Broadway model.',
            '',
            'First, you need to give the class name you want to generate.',
            'IMPORTANT!: Dont add model suffix!',
        ];
    }
}
