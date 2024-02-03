<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

class DummyValueObject
{
	protected string $valueObjectName;

	public function setValueObjectName(string $valueObjectName): void
	{
		$this->valueObjectName = $valueObjectName;
	}

	public function getValueObjectName() : string
	{
		return $this->valueObjectName;
	}
}