<?php

namespace Fifthgate\Objectivity\Core\Tests;

use Fifthgate\Objectivity\Core\Tests\Mocks\MockDomainEntity;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockSerializableDomainEntity;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockShadowableDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Exceptions\ShadowValueException;
use \DateTime;

class ShadowValueTest extends ObjectivityCoreTestCase
{
    private function makeShadowEntity()
    {
        $domainEntity = new MockShadowableDomainEntity;
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
        $domainEntity->setShadowValue('parent_id', 1);
        return $domainEntity;
    }
    public function testShadowValues()
    {

        $domainEntity = $this->makeShadowEntity();

        $this->assertEquals(1, $domainEntity->getShadowValue('parent_id'));        
        $this->assertTrue($domainEntity->isShadowableValue('parent_id'));
        $this->assertFalse($domainEntity->isShadowableValue('fakevalue'));
        $domainEntity->clearShadowValue('parent_id');
        $this->assertNull($domainEntity->getShadowValue('parent_id'));
    }

    public function testUnrealShadowValueSetException()
    {
        $domainEntity = $this->makeShadowEntity();
        $this->expectException(ShadowValueException::class);
        $domainEntity->setShadowValue('fakevalue', 2);
    }

    public function testUnrealShadowValueGetException()
    {
        $domainEntity = $this->makeShadowEntity();
        $this->expectException(ShadowValueException::class);
        $domainEntity->getShadowValue('fakeValue');
    }

    public function testUnrealShadowValueClearException()
    {
        $domainEntity = $this->makeShadowEntity();
        $this->expectException(ShadowValueException::class);
        $domainEntity->clearShadowValue('fakeValue');
    }
}
