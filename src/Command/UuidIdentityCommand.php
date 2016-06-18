<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Command;

use NullDev\Skeleton\CodeGenerator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\File\FileFactory;
use NullDev\Skeleton\File\FileGenerator;
use NullDev\Skeleton\File\FileResource;
use NullDev\Skeleton\Path\Readers\SourceCodePathReader;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
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
class UuidIdentityCommand extends GeneratorCommand
{
    private $paths;

    public function setPaths(array  $paths)
    {
        $this->paths = $paths;
    }

    protected function configure()
    {
        $this->setName('gnerate:value-object:uuid-identity')
            ->setDescription('Generates UUID identity value object')
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
            $questionHelper->writeSection($output, 'Generate UUID identity value object');

            $output->writeln(
                [
                    '',
                    'This command helps you generate UUID identity value objects.',
                    '',
                    'First, you need to give the class name you want to generate.',
                ]
            );
            while (true) {
                $namespaces = $this->getExistingPaths();
                $question   = new Question($questionHelper->getQuestion('Enter class name', ''));
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

        $classType = ClassType::create($className);

        $classSource  = $this->getSource($classType);
        $fileResource = $this->getFileResource($classSource);

        if (file_exists($fileResource->getFileName())) {
            $question = new ConfirmationQuestion('File exists, overwrite?', false);

            if (!$questionHelper->ask($input, $output, $question)) {
                return;
            }
        }

        $this->createFile($fileResource);
    }

    private function getSource(ClassType $classType) : ImprovedClassSource
    {
        $factory = new UuidIdentitySourceFactory(new ClassSourceFactory(), new DefinitionFactory());

        return $factory->create($classType);
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
