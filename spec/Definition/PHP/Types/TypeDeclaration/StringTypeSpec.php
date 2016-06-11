<?php

declare (strict_types = 1);
namespace spec\NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration;

use NullDev\Skeleton\Definition\PHP\Types\Type;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\TypeDeclaration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\StringType');
        $this->shouldHaveType(TypeDeclaration::class);
        $this->shouldHaveType(Type::class);
    }
}
