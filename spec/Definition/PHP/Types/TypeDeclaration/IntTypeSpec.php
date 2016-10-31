<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration;

use NullDev\Skeleton\Definition\PHP\Types\Type;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\TypeDeclaration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IntTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\IntType');
        $this->shouldHaveType(TypeDeclaration::class);
        $this->shouldHaveType(Type::class);
    }

    public function it_exposes_type_name()
    {
        $this->getName()->shouldReturn('int');
    }

    public function it_exposes_type_full_name()
    {
        $this->getFullName()->shouldReturn('int');
    }
}
