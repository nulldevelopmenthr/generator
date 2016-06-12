<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Command;

use Mockery as m;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Generator\PhpParserGeneratorFactory;
use NullDev\Skeleton\Path\Readers\SourceCodePathReader;
use NullDev\Skeleton\Popular\UuidFactory;
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
use Symfony\Component\Finder\Finder;

/**
 */
class UuidIdentityCommand extends GeneratorCommand
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

        if ($this->autoloader->findFile($className)) {
            $question = new ConfirmationQuestion('File exists, overwrite?', false);

            if (!$questionHelper->ask($input, $output, $question)) {
                return;
            }
        }

        $fileContent = $this->getContentOutput($className);
        $filePath    = $this->getFilePath($className);

        $this->createFile($filePath, $fileContent);
    }

    protected function createFile(string $fileName, string $fileContent) : bool
    {
        $fileDir = dirname($fileName);
        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }

        file_put_contents($fileName, $fileContent);

        return true;
    }

    protected function getContentOutput(string $className) : string
    {
        $classType = ClassType::create($className);
        $factory   = new UuidFactory($classType);

        $source = $factory->getSource();

        return $this->getFileGenerator()->getOutput($source);
    }

    protected function getFilePath(string $className) : string
    {
        $path = $this->getPathItBelongsTo($className);

        return $path->getFileNameFor($className);
    }

    protected function getPathItBelongsTo(string $className)
    {
        foreach ($this->paths as $path) {
            if ($path->belongsTo($className)) {
                return $path;
            }
        }

        throw new \Exception('Err 233523523: Cant find path that "'.$className.'" would belong to!');
    }

    protected function getExistingPaths() : array
    {
        $sourceCodePathReader = new SourceCodePathReader();

        return $sourceCodePathReader->getExistingPaths($this->paths);
    }

    protected function createGenerator()
    {
        throw new PendingException();
    }

    private function getFileGenerator()
    {
        return PhpParserGeneratorFactory::create();
    }
}
