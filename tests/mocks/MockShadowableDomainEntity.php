<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\ShadowsValuesInterface;
use Fifthgate\Objectivity\Core\Domain\Traits\ShadowsValues;

class MockShadowableDomainEntity extends AbstractSoftDeletingDomainEntity implements DomainEntityInterface, ShadowsValuesInterface
{

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
        $shadowableValues = [
            'parent_id'
        ];
        return in_array($shadowName, $shadowableValues);
    }
}
