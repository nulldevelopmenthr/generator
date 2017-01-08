<?php

declare(strict_types=1);

namespace NullDev\Skeleton\CodeGenerator\PhpParser;

use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpParser\BuilderFactory;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\TraitUse;

class ClassGenerator
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function generate(ImprovedClassSource $classSource)
    {
        //Building class.
        $classCode = $this->builderFactory->class($classSource->getName());

        //Add parent to class.
        if ($classSource->hasParent()) {
            $classCode->extend($classSource->getParentName());
        }

        //Add interfaces
        foreach ($classSource->getInterfaces() as $interface) {
            $classCode->implement($interface->getName());
        }

        //Add traits
        foreach ($classSource->getTraits() as $trait) {
            $classCode->addStmt($this->createTrait($trait));
        }

        foreach ($classSource->getProperties() as $property) {
            $classCode->addStmt($this->createClassProperty($property));
        }

        return $classCode;
    }

    protected function createTrait(TraitType $traitType)
    {
        return new TraitUse(
            [
                new Name($traitType->getName()),
            ]
        );
    }

    private function createClassProperty(Parameter $property)
    {
        return $this->builderFactory
            ->property($property->getName())
            ->makePrivate()
            ->setDocComment('/** @var '.$this->getClassType($property).' */');
    }

    private function getClassType(Parameter $property)
    {
        if ($property->hasClass()) {
            return $property->getClassType()->getName();
        }

        return '';
    }
}
