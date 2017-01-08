<?php

declare(strict_types=1);

namespace NullDev\Skeleton\Definition\PHP;

use NullDev\Skeleton\Definition\PHP\Types\Type;

class Parameter
{
    /** @var string */
    private $name;
    /** @var Type */
    private $classType;

    public function __construct(string $name, Type $classType = null)
    {
        $this->name      = $name;
        $this->classType = $classType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Type
     */
    public function getClassType(): Type
    {
        return $this->classType;
    }

    /**
     * @return string
     */
    public function getClassShortName(): string
    {
        return $this->getClassType()->getName();
    }

    public function hasClass()
    {
        if (null === $this->classType) {
            return false;
        }

        return true;
    }
}
