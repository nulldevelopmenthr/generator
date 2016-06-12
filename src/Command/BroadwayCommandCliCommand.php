<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Command;

use Mockery as m;
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
use NullDev\Skeleton\SourceFactory\Broadway\CommandSourceFactory;
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
 */
class BroadwayCommandCliCommand extends GeneratorCommand
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
        $this->setName('gnerate:broadway:command')
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
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        if (true === empty($input->getOption('className'))) {
            $questionHelper->writeSection($output, 'Generate Broadway command');

            $output->writeln(
                [
                    '',
                    'This command helps you generate Broadway commands.',
                    '',
                    'First, you need to give the class name you want to generate.',
                ]
            );
            $namespaces = $this->getExistingPaths();
            while (true) {
                $question = new Question($questionHelper->getQuestion('Enter Broadway command class name', ''));
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

        $fields = [];

        //
        //START  : FIELDS
        //
        //

        $existingClasses = $this->getExistingClasses();

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
            //$question->setAutocompleterValues($existingClasses);

            $parameterName = $questionHelper->ask($input, $output, $questionName);

            $fields[] = new Parameter($parameterName, $parameterClassType);
        }
        //
        //
        //  END  : FIELDS
        //

        $classType = ClassType::create($className);

        $classSource  = $this->getSource($classType, $fields);
        $fileResource = $this->getFileResource($classSource);

        if ($fileResource->fileExists()) {
            $question = new ConfirmationQuestion('File exists, overwrite?', false);

            if (!$questionHelper->ask($input, $output, $question)) {
                return;
            }
        }

        $this->createFile($fileResource);
    }

    private function createClassFromParameterClassName(string $name) : Type
    {
        return TypeFactory::createFromName($name);
    }

    private function getSource(ClassType $classType, array $fields) : ImprovedClassSource
    {
        $factory = new CommandSourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType, $fields);
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
