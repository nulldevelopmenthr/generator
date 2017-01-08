<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP\Types;

abstract class ConceptName implements Importable, Type
{
    const NAMESPACE_SEPARATOR = '\\';

    /** @var string */
    private $namespace;
    /** @var string */
    private $name;

    public function __construct(string $name, string $namespace = null)
    {
        $this->name      = $name;
        $this->namespace = $namespace;
    }

    public function hasNamespace(): bool
    {
        if (null === $this->namespace) {
            return false;
        }

        return true;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFullName(): string
    {
        if (null === $this->namespace) {
            return $this->getName();
        }

        return $this->namespace.'\\'.$this->name;
    }

    public static function create(string $fullName)
    {
        return static::createFromFullyQualified($fullName);
    }

    public static function createFromFullyQualified(string $fullName)
    {
        $parts = explode(self::NAMESPACE_SEPARATOR, $fullName);
        $name  = array_pop($parts);

        $namespace = null;

        if (count($parts) > 0) {
            $namespace = implode(self::NAMESPACE_SEPARATOR, $parts);
        }

        return new static($name, $namespace);
    }
}
