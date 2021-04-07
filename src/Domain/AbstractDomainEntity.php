<?php

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;

abstract class AbstractDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface
{
    protected $id = null;

    protected $createdAt;

    protected $updatedAt;

    protected $hash;

    public function isDirty() : bool
    {
        return ((!$this->hash) or ($this->hash != $this->hashSelf()));
    }

    public function hashSelf() : string
    {
        $vars = get_object_vars($this);
        unset($vars['hash']);
        $hash = md5(serialize($vars));
        $this->hash = $hash;
        return $hash;
    }

    public function setID($id)
    {
        $this->id = $id;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setCreatedAt(DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt)
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
}
