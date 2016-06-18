<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\File\FileFactory;
use NullDev\Skeleton\File\FileGenerator;
use NullDev\Skeleton\File\FileResource;
use NullDev\Skeleton\Path\Readers\SourceCodePathReader;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourcedAggregateRootSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourcingRepositorySourceFactory;
use NullDev\Skeleton\SourceFactory\UuidIdentitySourceFactory;
use PhpParser\Node;
use PhpSpec\Exception\Example\PendingException;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
class BroadwayModelCliCommand extends GeneratorCommand
{
    private $paths;

    public function setPaths(array  $paths)
    {
        $this->paths = $paths;
    }

    protected function configure()
    {
        $this->setName('gnerate:broadway:model')
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
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        if (true === empty($input->getOption('className'))) {
            $questionHelper->writeSection($output, 'Generate Broadway model');

            $output->writeln(
                [
                    '',
                    'This command helps you generate Broadway model.',
                    '',
                    'First, you need to give the class name you want to generate.',
                    'IMPORTANT!: Dont add model suffix!',
                ]
            );
            $namespaces = $this->getExistingPaths();
            while (true) {
                $question = new Question(
                    $questionHelper->getQuestion('Enter Broadway model class name (without model suffix)', '')
                );
                $question->setAutocompleterValues($namespaces);

                $className = $questionHelper->ask($input, $output, $question);

                if (true === empty($className)) {
                    $output->writeln('No class name, please enter it');
                } else {
                    break;
                }
            }

            $className = str_replace('/', '\\', $className);
        } else {
            $className = str_replace('/', '\\', $input->getOption('className'));
        }

        //Id

        $modelIdClassType = ClassType::create($className.'Id');

        $modelIdClassSource  = $this->getModelIdSource($modelIdClassType);
        $modelIdFileResource = $this->getFileResource($modelIdClassSource);

        if ($modelIdFileResource->fileExists()) {
            $question = new ConfirmationQuestion('Id file exists, overwrite?', false);

            if ($questionHelper->ask($input, $output, $question)) {
                $this->createFile($modelIdFileResource);
                $output->writeln('Id file created.');
            } else {
                $output->writeln('Id file skipped.');
            }
        } else {
            $this->createFile($modelIdFileResource);
            $output->writeln('Id file created.');
        }

        //Entity

        $modelClassType = ClassType::create($className.'Model');

        $modelClassSource  = $this->getModelSource($modelClassType, $modelIdClassType);
        $modelFileResource = $this->getFileResource($modelClassSource);

        if (file_exists($modelFileResource->getFileName())) {
            $question = new ConfirmationQuestion('Model file exists, overwrite?', false);

            if ($questionHelper->ask($input, $output, $question)) {
                $this->createFile($modelFileResource);
                $output->writeln('Model file created.');
            } else {
                $output->writeln('Model file skipped.');
            }
        } else {
            $this->createFile($modelFileResource);
            $output->writeln('Model file created.');
        }

        //Repository

        $repositoryClassType = ClassType::create($className.'Repository');

        $repositoryClassSource  = $this->getModelRepositorySource($repositoryClassType, $modelClassType);
        $repositoryFileResource = $this->getFileResource($repositoryClassSource);

        if (file_exists($repositoryFileResource->getFileName())) {
            $question = new ConfirmationQuestion('Model repository file exists, overwrite?', false);

            if ($questionHelper->ask($input, $output, $question)) {
                $this->createFile($repositoryFileResource);
                $output->writeln('Model repository file created.');
            } else {
                $output->writeln('Model repository file skipped.');
            }
        } else {
            $this->createFile($repositoryFileResource);
            $output->writeln('Model repository file created.');
        }
    }

    private function getModelIdSource(ClassType $modelIdClassType) : ImprovedClassSource
    {
        $factory = new UuidIdentitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($modelIdClassType);
    }

    private function getModelSource(ClassType $modelClassType, ClassType $modelIdClassType) : ImprovedClassSource
    {
        $factory = new EventSourcedAggregateRootSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        $parameter = new Parameter(lcfirst($modelIdClassType->getName()), $modelIdClassType);

        return $factory->create($modelClassType, $parameter);
    }

    private function getModelRepositorySource(
        ClassType $repositoryClassType,
        ClassType $modelClassType
    ) : ImprovedClassSource {
        $factory = new EventSourcingRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($repositoryClassType, $modelClassType);
    }

    private function getFileResource(ImprovedClassSource $classSource) : FileResource
    {
        $factory = new FileFactory($this->paths);

        return $factory->create($classSource);
    }

    private function createFile(FileResource $fileResource)
    {
        $fileGenerator = new FileGenerator(new Filesystem(), PhpParserGeneratorFactory::create());

        $fileGenerator->create($fileResource);
    }

    private function getExistingPaths() : array
    {
        $sourceCodePathReader = new SourceCodePathReader();

        return $sourceCodePathReader->getExistingPaths($this->paths);
    }

    protected function createGenerator()
    {
        throw new PendingException();
    }
}
