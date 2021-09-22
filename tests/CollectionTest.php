<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntityCollection;
use \DateTime;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntity;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockSerializableDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Collection\Exceptions\InvalidMassCallException;

class CollectionTest extends ObjectivityCoreTestCase
{
    
    public function testObjectIntegrity()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertNull($collection->first());
        $this->assertNull($collection->last());
        $this->assertEquals(0, $collection->count());
        $this->assertTrue($collection->isEmpty());

        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;
        //Timestamps
        $entityOne->setUpdatedAt(new DateTime('2012-12-12 12:12:12'));
        $entityTwo->setUpdatedAt(new DateTime('2011-11-11 11:11:11'));
        $entityThree->setUpdatedAt(new DateTime('2010-10-10 10:10:10'));
        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);
        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        //Add To Collection
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $this->assertTrue($collection->hasID(2));
        $this->assertFalse($collection->hasID(5));
        $this->assertEquals(3, $collection->count());
        $this->assertEquals($entityOne, $collection->first());
        $this->assertEquals($entityThree, $collection->last());



        /**
        * Test that rely on a full set should be made before this break.
        */
        $slicedCollection = $collection->slice(2);
        $this->assertEquals(2, count($slicedCollection));

        $firstN = $collection->getFirstN(2);

        $this->assertEquals(2, $firstN->count());

        $collection->rewind();
        $this->assertEquals(0, $collection->key());
        $collection->next();
        $this->assertEquals(1, $collection->key());
        $this->assertTrue($collection->valid());
        $collection->rewind();
        $this->assertEquals($entityOne, $collection->current());
        $collection->delete(2);
        $this->assertEquals(2, $collection->count());
        $this->assertFalse($collection->delete(5));

        $collection->sortCollection(function ($a, $b) {
            if ($a > $b) {
                return -1;
            }
            if ($a < $b) {
                return 1;
            }
            return 0;
        });
        $this->assertEquals(2, $collection->first()->getID());
        $this->assertEquals(1, $collection->last()->getID());
        
        

        $filteredCollection = $collection->filter(function ($item) {
            
            return $item->getID() == 1;
        });
        $this->assertEquals(1, $filteredCollection->count());
        
        $collection->flush();
        $this->assertEquals(0, $collection->count());
    }

    public function testHasKey()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertNull($collection->first());
        $this->assertNull($collection->last());
        $this->assertEquals(0, $collection->count());
        $this->assertTrue($collection->isEmpty());

        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;
        //Timestamps
        $entityOne->setUpdatedAt(new DateTime('2012-12-12 12:12:12'));
        $entityTwo->setUpdatedAt(new DateTime('2011-11-11 11:11:11'));
        $entityThree->setUpdatedAt(new DateTime('2010-10-10 10:10:10'));
        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);
        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        //Add To Collection
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $this->assertTrue($collection->hasItemWithFieldValue('getDummyStringValue', 'string1'));
        $this->assertFalse($collection->hasItemWithFieldValue('getDummyStringValue', 'dummy5'));
        $this->assertFalse($collection->hasItemWithFieldValue('completelymadeupmethod', 'dummy6'));
    }

    public function testEmptyHasKey()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertFalse($collection->hasItemWithFieldValue('getDummyStringValue', 'dummy5'));
    }

    public function testEmptyCall()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertFalse($collection->call(2, "setDummyStringValue", ["stringX"]));
    }

    public function testFilterByFieldValue()
    {
        $collection = new MockDomainEntityCollection;

        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;
        //Timestamps
        $entityOne->setUpdatedAt(new DateTime('2012-12-12 12:12:12'));
        $entityTwo->setUpdatedAt(new DateTime('2011-11-11 11:11:11'));
        $entityThree->setUpdatedAt(new DateTime('2010-10-10 10:10:10'));
        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);
        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        //Add To Collection
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);
        $this->assertNotNull($collection->filterByFieldValue('getDummyStringValue', 'string1'));
        $this->assertEquals($entityOne, $collection->filterByFieldValue('getDummyStringValue', 'string1')->first());
        $this->assertNull($collection->filterByFieldValue('getDummyStringValue', 'string5'));
        $this->assertNull($collection->filterByFieldValue('completelymadeupmethod', 'string1'));
    }

    public function testReplace()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        //Add To Collection
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $entityTwo->setDummyStringValue('string2Revised');
        $collection->replace(2, $entityTwo);
        $this->assertNotNull($collection->filterByFieldValue('getDummyStringValue', 'string2Revised'));
        $this->assertNull($collection->filterByFieldValue('getDummyStringValue', 'string2'));
        
        $revisedEntity2 = $collection->filterByFieldValue('getDummyStringValue', 'string2Revised')->first();
        $this->assertEquals(2, $revisedEntity2->getID());
        $this->assertEquals($entityTwoUpdatedAt, $revisedEntity2->getUpdatedAt());
    }

    public function testCall()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        //Add To Collection
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $this->assertTrue($collection->call(2, "setDummyStringValue", ["stringX"]));
        $this->assertFalse($collection->call(2, "completelyNonsensicalGetMethod", ["stringX"]));
        $revisedEntity2 = $collection->filterByFieldValue('getID', 2)->first();
        $this->assertEquals("stringX", $revisedEntity2->getDummyStringValue());
    }

    public function testMassCall()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        $entityOne->setDummySlugValue('slug1');
        $entityTwo->setDummySlugValue('slug2');
        $entityThree->setDummySlugValue('slug3');
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);
        $this->assertTrue($collection->massCall("setDummySlugValue", ["slugX"]));
        foreach ($collection as $item) {
            $this->assertEquals("slugX", $item->getDummySlugValue());
        }
        $revisedEntity1 = $collection->filterByFieldValue('getID', 1)->first();
        $revisedEntity2 = $collection->filterByFieldValue('getID', 2)->first();
        $revisedEntity3 = $collection->filterByFieldValue('getID', 3)->first();

        $this->assertEquals('string1', $revisedEntity1->getDummyStringValue());
        $this->assertEquals('string2', $revisedEntity2->getDummyStringValue());
        $this->assertEquals('string3', $revisedEntity3->getDummyStringValue());
    }

    public function testInvalidMassCall()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockDomainEntity;
        $entityTwo = new MockDomainEntity;
        $entityThree = new MockDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        $entityOne->setDummySlugValue('slug1');
        $entityTwo->setDummySlugValue('slug2');
        $entityThree->setDummySlugValue('slug3');
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $this->expectException(InvalidMassCallException::class);
        $collection->massCall("setNonnsensicalRunner", ["slugX"], true);
    }

    //Hotfix reversion check.
    public function testEmptyMassCall()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertFalse($collection->massCall("setNonnsensicalRunner", ["slugX"], true));
    }

    public function testEmptyFirstAndLast()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertNull($collection->first());
        $this->assertNull($collection->last());
    }
    public function testSerialize()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockSerializableDomainEntity;
        $entityTwo = new MockSerializableDomainEntity;
        $entityThree = new MockSerializableDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        $entityOne->setCreatedAt($entityOneUpdatedAt);
        $entityTwo->setCreatedAt($entityTwoUpdatedAt);
        $entityThree->setCreatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        $entityOne->setDummySlugValue('slug1');
        $entityTwo->setDummySlugValue('slug2');
        $entityThree->setDummySlugValue('slug3');
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $expected = [
            0 => [
                'dummy_string_value' => 'string1',
                'dummy_slug_value' => 'slug1',
                'created_at' => '2012-12-12 12:12:12',
                'updated_at' => '2012-12-12 12:12:12',
                'id' => 1
            ],
            1 => [
                'dummy_string_value' => 'string2',
                'dummy_slug_value' => 'slug2',
                'created_at' => '2011-11-11 11:11:11',
                'updated_at' => '2011-11-11 11:11:11',
                'id' => 2
            ],
            2 => [
                'dummy_string_value' => 'string3',
                'dummy_slug_value' => 'slug3',
                'created_at' => '2010-10-10 10:10:10',
                'updated_at' => '2010-10-10 10:10:10',
                'id' => 3
            ]
        ];
        $this->assertEquals($expected, $collection->jsonSerialize());
    }

    public function testGetItemByID()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockSerializableDomainEntity;
        $entityTwo = new MockSerializableDomainEntity;
        $entityThree = new MockSerializableDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        $entityOne->setCreatedAt($entityOneUpdatedAt);
        $entityTwo->setCreatedAt($entityTwoUpdatedAt);
        $entityThree->setCreatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        $entityOne->setDummySlugValue('slug1');
        $entityTwo->setDummySlugValue('slug2');
        $entityThree->setDummySlugValue('slug3');
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $this->assertEquals($collection->getItemByID(2), $entityTwo);
    }

    public function testFirstNEdgeCase()
    {
        $collection = new MockDomainEntityCollection;
        $this->assertTrue($collection->getFirstN(1)->isEmpty());
    }

    public function testGetNth()
    {
        $collection = new MockDomainEntityCollection;
        $entityOne = new MockSerializableDomainEntity;
        $entityTwo = new MockSerializableDomainEntity;
        $entityThree = new MockSerializableDomainEntity;

        $entityOneUpdatedAt = new DateTime('2012-12-12 12:12:12');
        $entityTwoUpdatedAt = new DateTime('2011-11-11 11:11:11');
        $entityThreeUpdatedAt = new DateTime('2010-10-10 10:10:10');
        //Timestamps
        $entityOne->setUpdatedAt($entityOneUpdatedAt);
        $entityTwo->setUpdatedAt($entityTwoUpdatedAt);
        $entityThree->setUpdatedAt($entityThreeUpdatedAt);

        $entityOne->setCreatedAt($entityOneUpdatedAt);
        $entityTwo->setCreatedAt($entityTwoUpdatedAt);
        $entityThree->setCreatedAt($entityThreeUpdatedAt);

        //ID
        $entityOne->setID(1);
        $entityTwo->setID(2);
        $entityThree->setID(3);

        //Dummy Value
        $entityOne->setDummyStringValue('string1');
        $entityTwo->setDummyStringValue('string2');
        $entityThree->setDummyStringValue('string3');

        $entityOne->setDummySlugValue('slug1');
        $entityTwo->setDummySlugValue('slug2');
        $entityThree->setDummySlugValue('slug3');
        $collection->add($entityOne);
        $collection->add($entityTwo);
        $collection->add($entityThree);

        $this->assertEquals($entityOne, $collection->getNth(1));
        $this->assertEquals($entityTwo, $collection->getNth(2));
        $this->assertEquals($entityThree, $collection->getNth(3));
        $this->assertNull($collection->getNth(5));
    }
}
