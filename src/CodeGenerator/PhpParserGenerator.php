<?php

declare(strict_types=1);

namespace NullDev\Skeleton\CodeGenerator;

use NullDev\Skeleton\CodeGenerator\PhpParser\ClassGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\MethodFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpParser\BuilderFactory;
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

    public function __construct(
        BuilderFactory $builderFactory,
        ClassGenerator $classGenerator,
        MethodFactory $methodFactory,
        PrettyPrinterAbstract $printer
    ) {
        $this->builderFactory = $builderFactory;
        $this->classGenerator = $classGenerator;
        $this->methodFactory  = $methodFactory;
        $this->printer        = $printer;
    }

    public function getNode(ImprovedClassSource $classSource)
    {
        //Namespace
        $code = $this->builderFactory->namespace($classSource->getNamespace());

        //Adds use to header of file
        foreach ($classSource->getImports() as $import) {
            $code->addStmt($this->builderFactory->use($import->getFullName()));
        }

        $classCode = $this->classGenerator->generate($classSource);

        foreach ($classSource->getMethods() as $method) {
            $result = $this->methodFactory->generate($method);

            $classCode->addStmt($result);
        }

        $code->addStmt($classCode);

        return $code->getNode();
    }

    public function getOutput(ImprovedClassSource $classSource): string
    {
        return $this->printer->prettyPrintFile([$this->getNode($classSource)]);
    }
}
