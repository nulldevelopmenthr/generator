<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\Type;
use NullDev\Skeleton\Definition\PHP\Types\TypeFactory;
use NullDev\Skeleton\File\FileFactory;
use NullDev\Skeleton\File\FileGenerator;
use NullDev\Skeleton\File\FileResource;
use NullDev\Skeleton\Path\Readers\SourceCodePathReader;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourcedAggregateRootSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\EventSourcingRepositorySourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\ReadEntitySourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\ReadProjectorSourceFactory;
use NullDev\Skeleton\SourceFactory\Broadway\ReadRepositorySourceFactory;
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
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class BroadwayReadCliCommand extends GeneratorCommand
{
    private $paths;
    private $autoloader;

    public function setPaths(array  $paths)
    {
        $this->paths = $paths;
    }

    public function setAutoloader($autoloader)
    {
        $this->autoloader = $autoloader;
    }

    protected function configure()
    {
        $this->setName('gnerate:broadway:read')
            ->setDescription('Generates Broadway read')
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
            $questionHelper->writeSection($output, 'Generate Broadway read');

            $output->writeln(
                [
                    '',
                    'This command helps you generate Broadway read.',
                    '',
                    'First, you need to give the class name you want to generate.',
                    'IMPORTANT!: Dont add entity suffix!',
                ]
            );
            $namespaces = $this->getExistingPaths();
            while (true) {
                $question = new Question(
                    $questionHelper->getQuestion('Enter Broadway read class name (without entity suffix)', '')
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

        $existingClasses      = $this->getExistingClasses();
        $readEntityProperties = [];

        while (true) {
            $question = new Question($questionHelper->getQuestion('Enter parameter class name', ''));
            $question->setAutocompleterValues($existingClasses);

            $parameterClassName = $questionHelper->ask($input, $output, $question);

            if (true === empty($parameterClassName)) {
                break;
            }
            $parameterClassType = $this->createClassFromParameterClassName($parameterClassName);

            $questionName = new Question(
                $questionHelper->getQuestion(
                    'Enter parameter name',
                    lcfirst($parameterClassType->getName())
                ),
                lcfirst($parameterClassType->getName())
            );

            $parameterName = $questionHelper->ask($input, $output, $questionName);

            $readEntityProperties[] = new Parameter($parameterName, $parameterClassType);
        }

        //Entity

        $readEntityClassType = ClassType::create($className.'Entity');

        $readEntityClassSource  = $this->getReadEntitySource($readEntityClassType, $readEntityProperties);
        $readEntityFileResource = $this->getFileResource($readEntityClassSource);

        if ($readEntityFileResource->fileExists()) {
            $question = new ConfirmationQuestion('Read entity file exists, overwrite?', false);

            if ($questionHelper->ask($input, $output, $question)) {
                $this->createFile($readEntityFileResource);
                $output->writeln('Read entity file created.');
            } else {
                $output->writeln('Read entity file skipped.');
            }
        } else {
            $this->createFile($readEntityFileResource);
            $output->writeln('Read entity file created.');
        }

        //Repository

        $repositoryClassType = ClassType::create($className.'Repository');

        $repositoryClassSource  = $this->getReadRepositorySource($repositoryClassType);
        $repositoryFileResource = $this->getFileResource($repositoryClassSource);

        if ($repositoryFileResource->fileExists()) {
            $question = new ConfirmationQuestion('Read repository file exists, overwrite?', false);

            if ($questionHelper->ask($input, $output, $question)) {
                $this->createFile($repositoryFileResource);
                $output->writeln('Read repository file created.');
            } else {
                $output->writeln('Read repository file skipped.');
            }
        } else {
            $this->createFile($repositoryFileResource);
            $output->writeln('Read repository file created.');
        }

        //Projector

        $readProjectorClassType = ClassType::create($className.'Id');

        $readProjectorClassSource  = $this->getReadProjectorSource($readProjectorClassType, $repositoryClassType);
        $readProjectorFileResource = $this->getFileResource($readProjectorClassSource);

        if ($readProjectorFileResource->fileExists()) {
            $question = new ConfirmationQuestion('Read projector file exists, overwrite?', false);

            if ($questionHelper->ask($input, $output, $question)) {
                $this->createFile($readProjectorFileResource);
                $output->writeln('Read projector file created.');
            } else {
                $output->writeln('Read projector file skipped.');
            }
        } else {
            $this->createFile($readProjectorFileResource);
            $output->writeln('Read projector file created.');
        }
    }

    private function getReadEntitySource(ClassType $readEntityClassType, array $parameters) : ImprovedClassSource
    {
        $factory = new ReadEntitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($readEntityClassType, $parameters);
    }

    private function getReadRepositorySource(ClassType $repositoryClassType) : ImprovedClassSource
    {
        $factory = new ReadRepositorySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($repositoryClassType);
    }

    private function getReadProjectorSource(
        ClassType $readProjectorClassType,
        ClassType $repositoryClassType
    ) : ImprovedClassSource {
        $factory = new ReadProjectorSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        $parameter = new Parameter(lcfirst($repositoryClassType->getName()), $repositoryClassType);

        return $factory->create($readProjectorClassType, [$parameter]);
    }

    private function getFileResource(ImprovedClassSource $classSource) : FileResource
    {
        $factory = new FileFactory($this->autoloader, $this->paths);

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

    private function createClassFromParameterClassName(string $name) : Type
    {
        return TypeFactory::createFromName($name);
    }

    private function getExistingClasses() : array
    {
        $sourceCodePathReader = new SourceCodePathReader();

        return $sourceCodePathReader->getExistingClasses($this->paths);
    }

    protected function createGenerator()
    {
        throw new PendingException();
    }
}
