<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Path;

use Exception;
use NullDev\Skeleton\Path\Psr4Path;
use PhpSpec\ObjectBehavior;

class Psr4PathSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = '');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Psr4Path::class);
    }

    public function it_returns_its_source_code_path()
    {
        $this->isSourceCode()->shouldReturn(true);
        $this->isSpecCode()->shouldReturn(false);
        $this->isTestsCode()->shouldReturn(false);
    }

    public function it_handles_when_no_class_base_defined()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = '');
        $this->getPathBase()->shouldReturn($pathBase);
        $this->getClassBase()->shouldReturn($classBase);
    }

    public function it_handles_when_class_base_is_defined()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = 'MyShop\\');
        $this->getPathBase()->shouldReturn($pathBase);
        $this->getClassBase()->shouldReturn($classBase);
    }

    public function it_throws_exception_if_path_base_missing_slash_at_end()
    {
        $this->shouldThrow(Exception::class)
            ->during__construct($pathBase = '/var/www/something/src', $classBase = 'MyShop\\');
    }

    public function it_throws_exception_if_class_base_not_empty_but_missing_backslash_at_end()
    {
        $this->shouldThrow(Exception::class)
            ->during__construct($pathBase = '/var/www/something/src/', $classBase = 'MyShop');
    }

    public function it_returns_belongs_to_as_true_when_class_base_empty()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = '');
        $this->belongsTo('MyShop\\Product')->shouldReturn(true);
    }

    public function it_knows_if_class_belongs_to_this_path()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = 'MyShop\\');

        $this->belongsTo('MyShop\\Product')->shouldReturn(true);
        $this->belongsTo('Shop\\Product')->shouldReturn(false);
    }

    public function it_calculates_file_path_from_class_name_for_empty_base_path()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = '');

        $this->getFileNameFor('MyShop\\Product')
            ->shouldReturn('/var/www/something/src/MyShop/Product.php');
    }

    public function it_calculates_file_path_from_class_name_for_class_base()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = 'MyShop\\');

        $this->getFileNameFor('MyShop\\Product')
            ->shouldReturn('/var/www/something/src/Product.php');
    }

    public function it_calculates_file_path_from_class_name_for_class_base_with_longer_base()
    {
        $this->beConstructedWith($pathBase = '/var/www/something/src/', $classBase = 'MyShop\\Something\\Somewhere\\');

        $this->getFileNameFor('MyShop\\Something\\Somewhere\\Product')
            ->shouldReturn('/var/www/something/src/Product.php');
    }
}
