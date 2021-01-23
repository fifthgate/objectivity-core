<?php

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;

abstract class AbstractDomainEntity implements DomainEntityInterface
{
    protected ?int $id = null;

    protected $createdAt;

    protected $updatedAt;

    protected $hash;

    final public function isDirty() : bool
    {
        return ((!$this->hash) or ($this->hash != $this->hashSelf()));
    }

    final public function hashSelf() : string
    {
        $vars = get_object_vars($this);
        unset($vars['hash']);
        $hash = md5(serialize($vars));
        $this->hash = $hash;
        return $hash;
    }

    public function setID(int $id)
    {
        $this->id = $id;
    }

    public function getID() : ?int
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
