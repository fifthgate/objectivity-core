<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;

abstract class AbstractDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface
{
    protected $id = null;

    protected DateTimeInterface $createdAt;

    protected DateTimeInterface $updatedAt;

    protected $hash;

    public function isDirty() : bool
    {
        return ((!$this->hash) or ($this->hash != $this->hashSelf()));
    }

    public function clearID(): void
    {
        $this->id = null;
    }

    public function hashSelf() : string
    {
        $vars = get_object_vars($this);
        unset($vars['hash']);
        $hash = md5(serialize($vars));
        $this->hash = $hash;
        return $hash;
    }

    public function setID($id): void
    {
        $this->id = $id;
    }

    public function getID(): ? int
    {
        return $this->id;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt() : DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt() : DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function __clone()
    {
        $this->clearID();
    }
}
