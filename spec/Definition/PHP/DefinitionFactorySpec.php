<?php

declare(strict_types=1);

namespace spec\NullDev\Skeleton\Definition\PHP;

use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\AggregateRootIdGetterMethod;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\CreateMethod;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\ReadModelIdGetterMethod;
use NullDev\Skeleton\Broadway\Definition\PHP\Methods\Model\RepositoryConstructorMethod;
use NullDev\Skeleton\Definition\PHP\DefinitionFactory;
use NullDev\Skeleton\Definition\PHP\Methods\ConstructorMethod;
use NullDev\Skeleton\Definition\PHP\Methods\DeserializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\GetterMethod;
use NullDev\Skeleton\Definition\PHP\Methods\SerializeMethod;
use NullDev\Skeleton\Definition\PHP\Methods\ToStringMethod;
use NullDev\Skeleton\Definition\PHP\Methods\UuidCreateMethod;
use NullDev\Skeleton\Definition\PHP\Parameter;
use NullDev\Skeleton\Definition\PHP\Types\ClassType;
use NullDev\Skeleton\Definition\PHP\Types\Type;
use NullDev\Skeleton\Source\ImprovedClassSource;
use PhpSpec\ObjectBehavior;

class DefinitionFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DefinitionFactory::class);
    }

    public function it_will_create_parameter(Type $type)
    {
        $this->createParameter('id', $type)->shouldReturnAnInstanceOf(Parameter::class);
    }

    public function it_will_create_constructor_method()
    {
        $this->createConstructorMethod([])->shouldReturnAnInstanceOf(ConstructorMethod::class);
    }

    public function it_will_create_deserialize_method(ImprovedClassSource $classSource)
    {
        $this->createDeserializeMethod($classSource)->shouldReturnAnInstanceOf(DeserializeMethod::class);
    }

    public function it_will_create_getter_method(Parameter $parameter)
    {
        $this->createGetterMethod($parameter)->shouldReturnAnInstanceOf(GetterMethod::class);
    }

    public function it_will_create_serialize_method(ImprovedClassSource $classSource)
    {
        $this->createSerializeMethod($classSource)->shouldReturnAnInstanceOf(SerializeMethod::class);
    }

    public function it_will_create_to_string_method(Parameter $parameter)
    {
        $this->createToStringMethod($parameter)->shouldReturnAnInstanceOf(ToStringMethod::class);
    }

    public function it_will_create_uuid_create_method(ClassType $classType)
    {
        $this->createUuidCreateMethod($classType)->shouldReturnAnInstanceOf(UuidCreateMethod::class);
    }

    public function it_will_create_broadway_model_create_method(ClassType $classType, Parameter $parameter)
    {
        $this->createBroadwayModelCreateMethod($classType, [$parameter])
            ->shouldReturnAnInstanceOf(CreateMethod::class);
    }

    public function it_will_create_broadway_model_aggregate_root_id_getter_method(Parameter $parameter)
    {
        $this->createBroadwayModelAggregateRootIdGetterMethod($parameter)
            ->shouldReturnAnInstanceOf(AggregateRootIdGetterMethod::class);
    }

    public function it_will_create_broadway_model_repository_constructor_method(ClassType $classType)
    {
        $this->createBroadwayModelRepositoryConstructorMethod($classType)
            ->shouldReturnAnInstanceOf(RepositoryConstructorMethod::class);
    }

    public function it_will_create_broadway_read_entity_id_getter_method(Parameter $parameter)
    {
        $this->createReadModelIdGetterMethod($parameter)
            ->shouldReturnAnInstanceOf(ReadModelIdGetterMethod::class);
    }
}
