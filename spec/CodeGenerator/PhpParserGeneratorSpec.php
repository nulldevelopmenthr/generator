<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\CodeGenerator;

use NullDev\Skeleton\CodeGenerator\PhpParser\ClassGenerator;
use NullDev\Skeleton\CodeGenerator\PhpParser\MethodFactory;
use NullDev\Skeleton\CodeGenerator\PhpParserGenerator;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinterAbstract;
use PhpSpec\ObjectBehavior;

class PhpParserGeneratorSpec extends ObjectBehavior
{
    public function let(
        BuilderFactory $builderFactory,
        ClassGenerator $classGenerator,
        MethodFactory $methodFactory,
        PrettyPrinterAbstract $printer
    ) {
        $this->beConstructedWith($builderFactory, $classGenerator, $methodFactory, $printer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PhpParserGenerator::class);
    }
}
