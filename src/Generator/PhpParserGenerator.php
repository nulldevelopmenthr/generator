<?php

declare (strict_types = 1);
namespace NullDev\Skeleton\Generator;

use NullDev\Skeleton\Generator\PhpParser\ClassGenerator;
use NullDev\Skeleton\Generator\PhpParser\MethodFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\PrettyPrinterAbstract;

/**
 * @todo: Reason this class exists
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * @see PhpParserGeneratorSpec
 * @see PhpParserGeneratorTest
 */
class PhpParserGenerator
{
    private $builderFactory;
    private $classGenerator;
    private $methodFactory;
    private $printer;
    private $classSource;

    public function __construct(
        BuilderFactory $builderFactory,
        ClassGenerator $classGenerator,
        MethodFactory $methodFactory,
        PrettyPrinterAbstract $printer,
        ImprovedClassSource $classSource
    ) {
        $this->builderFactory = $builderFactory;
        $this->classGenerator = $classGenerator;
        $this->methodFactory  = $methodFactory;
        $this->printer        = $printer;
        $this->classSource    = $classSource;
    }

    public function getNode()
    {
        //Namespace
        $code = $this->builderFactory->namespace($this->classSource->getNamespace());

        //Adds use to header of file
        foreach ($this->classSource->getImports() as $import) {
            $code->addStmt($this->builderFactory->use($import->getFullName()));
        }

        $classCode = $this->classGenerator->generate($this->classSource);

        foreach ($this->classSource->getMethods() as $method) {
            $result = $this->methodFactory->generate($method);

            $classCode->addStmt($result);
        }

        $code->addStmt($classCode);

        return $code->getNode();
    }

    public function getOutput()
    {
        return $this->printer->prettyPrintFile([$this->getNode()]);
    }
}
