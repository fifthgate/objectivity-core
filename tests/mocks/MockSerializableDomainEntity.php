<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSerializableDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\JsonSerializableDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Traits\JsonSerializes;

class MockSerializableDomainEntity extends AbstractSerializableDomainEntity implements JsonSerializableDomainEntityInterface {

    use JsonSerializes;
    
    protected string $dummyStringValue;

    protected string $dummySlugValue;

    public function setDummySlugValue(string $dummySlugValue) {
        $this->dummySlugValue = $dummySlugValue;
    }

    public function getDummySlugValue() : string {
        return $this->dummySlugValue;
    }
    public function setDummyStringValue(string $dummyStringValue) {
        $this->dummyStringValue = $dummyStringValue;
    }

    public function getDummyStringValue() : string {
        return $this->dummyStringValue;
    }
}