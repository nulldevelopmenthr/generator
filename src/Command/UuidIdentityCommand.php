<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UuidIdentityCommand extends BaseSkeletonGeneratorCommand
{
    protected $input;
    protected $output;

    protected function configure()
    {
        $this->setName('uuid')
            ->setDescription('Generates UUID identity value object')
            ->addOption('className', null, InputOption::VALUE_REQUIRED, 'Class name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        $className = $this->handleClassNameInput();

        $classType    = ClassType::create($className);
        $classSource  = $this->getSource($classType);
        $fileResource = $this->getFileResource($classSource);

        $this->handleGeneratingFile($fileResource);

        //Generating PHPSpec.
        $createSpecQuestion = new ConfirmationQuestion('Create PHPSpec file? (default=y)', true);
        if ($this->askQuestion($createSpecQuestion)) {
            $specSource   = $this->createSpecSource($classSource);
            $specResource = $this->getFileResource($specSource);
            $this->handleGeneratingFile($specResource);
        }
    }

    protected function getSource(ClassType $classType): ImprovedClassSource
    {
        $factory = new UuidIdentitySourceFactory(
            new ClassSourceFactory(),
            new DefinitionFactory()
        );

        return $factory->create($classType);
    }

    protected function getSectionMessage()
    {
        return 'Generate UUID identity value object';
    }

    protected function getIntroductionMessage()
    {
        return [
            '',
            'This command helps you generate UUID identity value objects.',
            '',
            'First, you need to give the class name you want to generate.',
        ];
    }
}
