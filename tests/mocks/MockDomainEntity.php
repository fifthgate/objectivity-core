<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

class MockDomainEntity extends AbstractSoftDeletingDomainEntity implements DomainEntityInterface {

	protected string $dummyStringValue;

	public function setDummyStringValue(string $dummyStringValue) {
		$this->dummyStringValue = $dummyStringValue;
	}

	public function getDummyStringValue() : string {
		return $this->dummyStringValue;
	}
}