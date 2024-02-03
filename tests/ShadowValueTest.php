<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Tests;

use DateTime;
use Fifthgate\Objectivity\Core\Domain\Traits\Exceptions\ShadowValueException;
use Fifthgate\Objectivity\Core\Tests\Mocks\MockShadowableDomainEntity;

class ShadowValueTest extends ObjectivityCoreTestCase
{
    /**
     * @throws ShadowValueException
     */
    private function makeShadowEntity(): MockShadowableDomainEntity
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

    /**
     * @throws ShadowValueException
     */
    public function testShadowValues(): void
    {

        $domainEntity = $this->makeShadowEntity();

        $this->assertEquals(1, $domainEntity->getShadowValue('parent_id'));        
        $this->assertTrue($domainEntity->isShadowableValue('parent_id'));
        $this->assertFalse($domainEntity->isShadowableValue('fakevalue'));
        $domainEntity->clearShadowValue('parent_id');
        $this->assertNull($domainEntity->getShadowValue('parent_id'));
    }

    public function testUnrealShadowValueSetException(): void
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
