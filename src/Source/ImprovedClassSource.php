<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Source;

use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\GetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\Method;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\Importable;
use NullDev\Skeleton\Definition\PHP\Types\InterfaceType;
use NullDev\Skeleton\Definition\PHP\Types\TraitType;
use NullDev\Skeleton\Definition\PHP\Types\Type;

/**
 * @see ImprovedClassSourceSpec
 */
class ImprovedClassSource
{
    private $classType;
    private $parent;
    private $interfaces = [];
    private $traits     = [];
    private $constructor;

    private $properties = [];
    private $methods    = [];

    private $imports = [];

    /**
     * ImprovedClassSource constructor.
     *
     * @param ClassType $classType
     */
    public function __construct(ClassType $classType)
    {
        $this->classType = $classType;
    }

    /**
     * @return ClassType
     */
    public function getClassType(): ClassType
    {
        return $this->classType;
    }

    public function hasNamespace(): bool
    {
        return $this->classType->hasNamespace();
    }

    public function getNamespace(): string
    {
        return $this->classType->getNamespace();
    }

    public function getName(): string
    {
        return $this->classType->getName();
    }

    public function getFullName(): string
    {
        return $this->classType->getFullName();
    }

    //-----     Parent     -----

    public function addParent(ClassType $parent)
    {
        if ($this->hasParent()) {
            throw new \Exception('Err 1000100: Class already has parent!');
        }

        $this->parent = $parent;

        $this->addImportIfEligible($parent);

        return $this;
    }

    public function hasParent(): bool
    {
        if (null === $this->parent) {
            return false;
        }

        return true;
    }

    public function getParent(): ClassType
    {
        return $this->parent;
    }

    public function getParentName(): string
    {
        return $this->getParent()->getName();
    }

    //-----     Interfaces     -----

    public function addInterface(InterfaceType $interface)
    {
        $this->interfaces[] = $interface;
        $this->addImportIfEligible($interface);

        return $this;
    }

    public function hasInterfaces()
    {
        if (0 === count($this->interfaces)) {
            return false;
        }

        return true;
    }

    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    //-----     Traits     -----

    public function addTrait(TraitType $trait)
    {
        $this->traits[] = $trait;
        $this->addImportIfEligible($trait);

        return $this;
    }

    public function hasTraits()
    {
        if (0 === count($this->traits)) {
            return false;
        }

        return true;
    }

    public function getTraits(): array
    {
        return $this->traits;
    }

    //-----     ConstructorMethod     -----

    public function hasConstructorMethod()
    {
        if (null === $this->constructor) {
            return false;
        }

        return true;
    }

    public function addConstructorMethod(ConstructorMethod $constructor)
    {
        if ($this->hasConstructorMethod()) {
            throw new \Exception('Err 1000200: Class already has constructor!');
        }

        $this->constructor = $constructor;

        foreach ($constructor->getMethodParameters() as $parameter) {
            if ($parameter->hasClass()) {
                $this->addImportIfEligible($parameter->getClassType());
            }
            $this->addProperty($parameter);
        }

        $this->addMethod($constructor);

        foreach ($constructor->getMethodParameters() as $parameter) {
            $this->addGetterMethod($parameter);
        }

        return $this;
    }

    public function getConstructorMethod(): ConstructorMethod
    {
        return $this->constructor;
    }

    public function getConstructorParameters(): array
    {
        if (false === $this->hasConstructorMethod()) {
            return [];
        }

        return $this->constructor->getMethodParameters();
    }

    //-----     Properties     -----

    public function addProperty(Parameter $property)
    {
        $this->properties[] = $property;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    //-----     Methods     -----

    public function addGetterMethod(Parameter $parameter)
    {
        $this->addMethod(new GetterMethod($parameter));
    }

    public function addMethod(Method $method)
    {
        $this->methods[] = $method;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    //-----     Import     -----

    public function addImport(Type $import)
    {
        return $this->addImportIfEligible($import);
    }

    private function addImportIfEligible(Type $import)
    {
        if ($import instanceof Importable) {
            if (false === in_array($import, $this->imports)) {
                $this->imports[] = $import;
            }
        }
    }

    public function getImports()
    {
        $sorter = function ($first, $second) {
            return $first->getFullName() <=> $second->getFullName();
        };
        usort($this->imports, $sorter);

        return $this->imports;
    }
}
