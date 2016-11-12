<?php

declare(strict_types=1);

namespace NullDev\Skeleton\SpecGenerator;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\ExposeConstructorArgumentsAsGettersMethod;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\InitializableMethod;
use NullDev\Skeleton\PhpSpec\Definition\PHP\Methods\LetMethod;
use NullDev\Skeleton\Source\ClassSourceFactory;
use NullDev\Skeleton\Source\ImprovedClassSource;

class SpecGenerator
{
    /**
     * @var ClassSourceFactory
     */
    private $factory;

    public function __construct(ClassSourceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function generate(ImprovedClassSource $improvedClassSource)
    {
        $specClassType = ClassType::create('spec\\'.$improvedClassSource->getClassType()->getFullName().'Spec');

        $specSource = $this->factory->create($specClassType);

        foreach ($improvedClassSource->getImports() as $import) {
            if (false === $import instanceof TraitType) {
                $specSource->addImport($import);
            }
        }

        $specSource->addImport($improvedClassSource->getClassType());
        $specSource->addImport(ClassType::create('Prophecy\Argument'));
        $specSource->addParent(ClassType::create('PhpSpec\ObjectBehavior'));

        $initializable = [
            $improvedClassSource->getClassType(),
        ];

        if ($improvedClassSource->hasParent()) {
            $initializable[] = $improvedClassSource->getParent();
        }

        foreach ($improvedClassSource->getInterfaces() as $interface) {
            $initializable[] = $interface;
        }

        $lets = $improvedClassSource->getConstructorParameters();

        foreach ($improvedClassSource->getConstructorParameters() as $methodParameter) {
            if ($methodParameter->hasClass()) {
                $specSource->addImport($methodParameter->getClassType());
            }
        }

        //@TODO:
        foreach ($improvedClassSource->getMethods() as $method) {
            if ($method instanceof RepositoryConstructorMethod) {
                $lets[] = new Parameter('eventStore', InterfaceType::create('Broadway\EventStore\EventStoreInterface'));
                $lets[] = new Parameter('eventBus', InterfaceType::create('Broadway\EventHandling\EventBusInterface'));
                $lets[] = new Parameter('eventStreamDecorators', new ArrayType());
            }
        }

        $specSource->addMethod(new LetMethod($lets));
        $specSource->addMethod(new InitializableMethod($initializable));

        $skip = false;

        if (true === $improvedClassSource->hasParent()) {
            if ($improvedClassSource->getParent()->getFullName() === 'Broadway\EventSourcing\EventSourcingRepository') {
                $skip = true;
            }
        }

        if (false === $skip) {
            $specSource->addMethod(new ExposeConstructorArgumentsAsGettersMethod($lets));
        }

        return $specSource;
    }
}
