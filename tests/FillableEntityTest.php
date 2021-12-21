<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntity;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockFillableDomainEntity;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockSerializableDomainEntity;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockShadowableDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Exceptions\ShadowValueException;
use \DateTime;
use Fifthgate\Objectivity\Core\Tests\Mocks\DummyValueObject;
use Fifthgate\Objectivity\Core\Domain\Traits\Exceptions\FillableInvalidValueException;

class FillableEntityTest extends ObjectivityCoreTestCase
{
    public function testFill()
    {
        $dummyValueObject = new DummyValueObject;
        $dummyValueObject->setValueObjectName("Test Value Object");
        
        $validArray = [
            'dummy_string_value' => "Dummy String",
            'dummy_slug_value' => "dummy_slug",
            'dummy_date' => "2020-01-01",
            'dummy_value_object' => $dummyValueObject,
            'dummy_int' => 5,
            'dummy_float' => 3.142,
            'dummy_bool' => true,
            'dummy_array' => [
                'lorem',
                'ipsum',
                'dolor'
            ]
        ];

        $filledEntity = MockFillableDomainEntity::fill($validArray);
        $this->assertEquals("Dummy String", $filledEntity->getDummyStringValue());
        $this->assertEquals("dummy_slug", $filledEntity->getDummySlugValue());
        $this->assertNotNull($filledEntity->getDummyDate());
        $this->assertEquals("2020-01-01", $filledEntity->getDummyDate()->format('Y-m-d'));
        $this->assertEquals("Test Value Object", $filledEntity->getDummyValueObject()->getValueObjectName());
        $this->assertEquals(5, $filledEntity->getDummyInt());
        $this->assertEquals(3.142, $filledEntity->getDummyFloat());
        $this->assertTrue($filledEntity->getDummyBool());
        $this->assertEquals(['lorem', 'ipsum', 'dolor'], $filledEntity->getDummyArray());

    }

    public function testValueTypeMismatch()
    {
        $dummyValueObject = new DummyValueObject;
        $dummyValueObject->setValueObjectName("Test Value Object");
        
        $invalidArray = [
            'dummy_string_value' => $dummyValueObject
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testUnparseableDate()
    {
        $invalidArray = [
             'dummy_date' => "sdfljkisdfjlkwqkjl",
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testNonString()
    {
        $invalidArray = [
            'dummy_string_value' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

     public function testNonBool() {
        $invalidArray = [
            'dummy_bool' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testNonInt() {
        $invalidArray = [
            'dummy_int' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testNonArray() {
        $invalidArray = [
            'dummy_array' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testNonFloat() {
        $invalidArray = [
            'dummy_float' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testObjectTypeMismatch()
    {
        $invalidArray = [
            'dummy_value_object' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testNonExistentSetterMethod()
    {
        $invalidArray = [
            'i_do_not_exist' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);
    }

    public function testNonPublicSetter()
    {
        $invalidArray = [
            'private_date' => new DateTime
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);    
    }

    public function testTooManyParameters()
    {
        $invalidArray = [
            'too_many_parameters' => 'lorem'
        ];
        $this->expectException(FillableInvalidValueException::class);
        $filledEntity = MockFillableDomainEntity::fill($invalidArray);       
    }
}
