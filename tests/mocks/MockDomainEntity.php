<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

class MockDomainEntity extends AbstractSoftDeletingDomainEntity implements DomainEntityInterface {

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