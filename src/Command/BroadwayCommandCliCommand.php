<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\Broadway\SourceFactory\CommandSourceFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BroadwayCommandCliCommand extends BaseSkeletonGeneratorCommand
{
    protected function configure()
    {
        $this->setName('broadway:command')
            ->setDescription('Generates Broadway command')
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

        $className = $this->handleClassNameInput();
        $fields    = $this->getConstuctorParameters();

        $classType    = ClassType::create($className);
        $classSource  = $this->getSource($classType, $fields);
        $fileResource = $this->getFileResource($classSource);

        $this->handleGeneratingFile($fileResource);

        // Generate PHPSpec file?
        if ($this->io->confirm('Create PHPSpec file?', true)) {
            $specSource   = $this->createSpecSource($classSource);
            $specResource = $this->getFileResource($specSource);
            $this->handleGeneratingFile($specResource);
        }
    }

    private function getSource(ClassType $classType, array $fields): ImprovedClassSource
    {
        $factory = new CommandSourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        return $factory->create($classType, $fields);
    }

    protected function getSectionMessage(): string
    {
        return 'Generate Broadway command';
    }

    protected function getIntroductionMessage(): array
    {
        return [
            '',
            'This command helps you generate Broadway commands.',
            '',
            'First, you need to give the class name you want to generate.',
        ];
    }
}
