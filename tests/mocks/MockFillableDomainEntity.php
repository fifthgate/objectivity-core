<?php

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\FillableInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Tests\Mocks\DummyValueObject;
use Fifthgate\Objectivity\Core\Domain\Traits\Fillable;

class MockFillableDomainEntity extends AbstractSoftDeletingDomainEntity implements FillableInterface, DomainEntityInterface {

	use Fillable;

	protected int $dummyInt;

	protected float $dummyFloat;

	protected bool $dummyBool;

	protected array $dummyArray;

	protected string $dummyStringValue;

	protected string $dummySlugValue;

	protected DateTimeInterface $dummyDate; 

	protected DummyValueObject $dummyValueObject;

	private DateTimeInterface $privateDate;

	public function setDummySlugValue(string $dummySlugValue): void {
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

	public function setDummyDate(DateTimeInterface $dummyDate): void
	{
		$this->dummyDate = $dummyDate;
	}

	public function getDummyDate() : DateTimeInterface
	{
		return $this->dummyDate;
	}

	public function setDummyValueObject(DummyValueObject $dummyValueObject)
	{
		$this->dummyValueObject = $dummyValueObject;
	}

	public function getDummyValueObject() : DummyValueObject
	{
		return $this->dummyValueObject;
	}

	public function setDummyInt(int $dummyInt): void
	{
		$this->dummyInt = $dummyInt;
	}

	public function getDummyInt() : int
	{
		return $this->dummyInt;
	}

	public function setDummyFloat(float $dummyFloat): void
	{
		$this->dummyFloat = $dummyFloat;
	}

	public function getDummyFloat() : float
	{
		return $this->dummyFloat;
	}

	public function setDummyBool(bool $dummyBool): void
	{
		$this->dummyBool = $dummyBool;
	}

	public function getDummyBool() : bool
	{
		return $this->dummyBool;
	}

	public function setDummyArray(array $dummyArray): void
	{
		$this->dummyArray = $dummyArray;
	}

	public function getDummyArray() : array
	{
		return $this->dummyArray;
	}

	private function setPrivateDate(DateTimeInterface $privateDate)
	{
		$this->privateDate = $privateDate;
	}

	public function setTooManyParameters(string $parameter1, string $parameter2): void
	{
		die("I should never get here.");
	}
}