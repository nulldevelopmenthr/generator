<?php

declare(strict_types=1);

namespace NullDev\Skeleton\SpecGenerator;

use NullDev\Skeleton\Definition\PHP\Methods\Broadway\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\InitializableMethod;
use NullDev\Skeleton\Definition\PHP\Methods\PhpSpec\LetMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\ArrayType;
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

        return $specSource;
    }
}
