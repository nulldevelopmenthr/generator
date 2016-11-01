<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration;

use NullDev\Skeleton\Definition\PHP\Types\Type;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\BoolType;
use NullDev\Skeleton\Definition\PHP\Types\TypeDeclaration\TypeDeclaration;
use PhpSpec\ObjectBehavior;

class BoolTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BoolType::class);
        $this->shouldHaveType(TypeDeclaration::class);
        $this->shouldHaveType(Type::class);
    }

    public function it_exposes_type_name()
    {
        $this->getName()->shouldReturn('bool');
    }

    public function it_exposes_type_full_name()
    {
        $this->getFullName()->shouldReturn('bool');
    }
}
