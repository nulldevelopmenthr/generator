<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Generator\PhpParser;

use NullDev\Skeleton\Generator\PhpParser\Methods\ConstructorGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\DeserializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\GetterGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\SerializeGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\ToStringGenerator;
use NullDev\Skeleton\Generator\PhpParser\Methods\UuidCreateGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodFactorySpec extends ObjectBehavior
{
    public function let(
        ConstructorGenerator $constructorGenerator,
        DeserializeGenerator $deserializeGenerator,
        GetterGenerator $getterGenerator,
        SerializeGenerator $serializeGenerator,
        ToStringGenerator $toStringGenerator,
        UuidCreateGenerator $uuidCreateGenerator
    ) {
        $this->beConstructedWith(
            $constructorGenerator,
            $deserializeGenerator,
            $getterGenerator,
            $serializeGenerator,
            $toStringGenerator,
            $uuidCreateGenerator
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Generator\PhpParser\MethodFactory');
    }
}
