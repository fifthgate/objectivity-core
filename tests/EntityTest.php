<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntity;
use \DateTime;

class EntityTest extends ObjectivityCoreTestCase {
	
	public function testObjectIntegrity() {
		$domainEntity = new MockDomainEntity;
		$domainEntity->setID(987);
		$this->assertEquals(987, $domainEntity->getID());
		$createdAt = new DateTime('2009-10-13 09:09:09');
		$domainEntity->setCreatedAt($createdAt);
		$this->assertEquals($createdAt, $domainEntity->getCreatedAt());

		$updatedAt = new DateTime('2009-10-14 09:09:09');
		$domainEntity->setUpdatedAt($updatedAt);
		$this->assertEquals($updatedAt, $domainEntity->getUpdatedAt());

		$domainEntity->hashSelf();
		$this->assertFalse($domainEntity->isDirty());

		$newUpdatedAt = new DateTime('2009-10-15 09:09:09');
		$domainEntity->setUpdatedAt($newUpdatedAt);
		$this->assertTrue($domainEntity->isDirty());

		$deletedAt = new DateTime('2009-10-16 09:09:09');
		$domainEntity->setDeletedAt($deletedAt);
		$this->assertEquals($deletedAt, $domainEntity->getDeletedAt());
	}
}