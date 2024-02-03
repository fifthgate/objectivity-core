<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

class MockDomainEntity extends AbstractSoftDeletingDomainEntity implements DomainEntityInterface {

	protected string $dummyStringValue;

	protected string $dummySlugValue;

	public function setDummySlugValue(string $dummySlugValue): void {
		$this->dummySlugValue = $dummySlugValue;
	}

	public function getDummySlugValue() : string {
		return $this->dummySlugValue;
	}
	public function setDummyStringValue(string $dummyStringValue): void {
		$this->dummyStringValue = $dummyStringValue;
	}

	public function getDummyStringValue() : string {
		return $this->dummyStringValue;
	}
}