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

    public function setDummySlugValue(string $dummySlugValue)
    {
        $this->dummySlugValue = $dummySlugValue;
    }

    public function getDummySlugValue() : string
    {
        return $this->dummySlugValue;
    }
    public function setDummyStringValue(string $dummyStringValue)
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
