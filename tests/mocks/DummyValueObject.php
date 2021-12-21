<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

class DummyValueObject
{
	protected string $valueObjectName;

	public function setValueObjectName(string $valueObjectName)
	{
		$this->valueObjectName = $valueObjectName;
	}

	public function getValueObjectName() : string
	{
		return $this->valueObjectName;
	}
}