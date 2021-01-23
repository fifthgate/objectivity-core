<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntityCollection;
use \DateTime;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntity;
class CollectionTest extends ObjectivityCoreTestCase {
	
	public function testObjectIntegrity() {
		$collection = new MockDomainEntityCollection;
		$this->assertNull($collection->first());
		$this->assertNull($collection->last());
		$this->assertEquals(0, $collection->count());
		$this->assertTrue($collection->isEmpty());

		$entityOne = new MockDomainEntity;
		$entityTwo = new MockDomainEntity;
		$entityThree = new MockDomainEntity;

		$entityOne->setUpdatedAt(new DateTime('2012-12-12 12:12:12'));
		$entityTwo->setUpdatedAt(new DateTime('2011-11-11 11:11:11'));
		$entityThree->setUpdatedAt(new DateTime('2010-10-10 10:10:10'));
		$entityOne->setID(1);
		$entityTwo->setID(2);
		$entityThree->setID(3);
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

		$collection->sortCollection(function ($a, $b){
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
}