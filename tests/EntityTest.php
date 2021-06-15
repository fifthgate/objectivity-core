<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntity;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockSerializableDomainEntity;
use \DateTime;

class EntityTest extends ObjectivityCoreTestCase
{
    
    public function testObjectIntegrity()
    {
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

        $domainEntity->setDummyStringValue('dummy');
        $this->assertEquals('dummy', $domainEntity->getDummyStringValue());

        $domainEntity->setDummySlugValue("dummy_slug");
        $this->assertEquals("dummy_slug", $domainEntity->getDummySlugValue());

        $domainEntity->clearID();
        $this->assertNull($domainEntity->getID());
    }

    public function testSerialization()
    {
        $domainEntity = new MockSerializableDomainEntity;
        $domainEntity->setID(987);
        $updatedAt = new DateTime('2009-10-14 09:09:09');
        $domainEntity->setUpdatedAt($updatedAt);
        $domainEntity->setCreatedAt($updatedAt);
        $domainEntity->setDummyStringValue("dummyString");
        $domainEntity->setDummySlugValue("dummy_slug");
        $expected = [
            'id' => 987,
            'updated_at' => '2009-10-14 09:09:09',
            'created_at' => '2009-10-14 09:09:09',
            'dummy_string_value' => 'dummyString',
            'dummy_slug_value' => 'dummy_slug'
        ];
        $this->assertEquals($expected, $domainEntity->jsonSerialize());
    }

    public function testClone()
    {
        $domainEntity = new MockDomainEntity;
        $domainEntity->setID(987);
        $createdAt = new DateTime('2009-10-13 09:09:09');
        $domainEntity->setCreatedAt($createdAt);
        $updatedAt = new DateTime('2009-10-14 09:09:09');
        $domainEntity->setUpdatedAt($updatedAt);
        $domainEntity->hashSelf();
        $newUpdatedAt = new DateTime('2009-10-15 09:09:09');
        $domainEntity->setUpdatedAt($newUpdatedAt);
        $deletedAt = new DateTime('2009-10-16 09:09:09');
        $domainEntity->setDeletedAt($deletedAt);
        $domainEntity->setDummyStringValue('dummy');
        $domainEntity->setDummySlugValue("dummy_slug");

        $clonedEntity = clone $domainEntity;
        $this->assertNull($clonedEntity->getID());
    }
}
