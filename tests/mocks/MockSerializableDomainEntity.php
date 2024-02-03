<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSerializableDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\JsonSerializableDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Traits\JsonSerializes;
use Fifthgate\Objectivity\Core\Domain\Traits\ShadowsValues;

class MockSerializableDomainEntity extends AbstractSerializableDomainEntity implements JsonSerializableDomainEntityInterface
{

    use JsonSerializes;

    use ShadowsValues;
    
    protected string $dummyStringValue;

    protected string $dummySlugValue;

    public function setDummySlugValue(string $dummySlugValue): void
    {
        $this->dummySlugValue = $dummySlugValue;
    }

    public function getDummySlugValue() : string
    {
        return $this->dummySlugValue;
    }
    public function setDummyStringValue(string $dummyStringValue): void
    {
        $this->dummyStringValue = $dummyStringValue;
    }

    public function getDummyStringValue() : string
    {
        return $this->dummyStringValue;
    }

    public function isShadowableValue(string $shadowName) : bool
    {
        return true;
    }
}
