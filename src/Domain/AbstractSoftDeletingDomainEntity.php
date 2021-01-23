<?php

namespace Fifthgate\Objectivity\Domain;

use Fifthgate\Objectivity\Domain\AbstractDomainEntity;
use Fifthgate\Objectivity\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;


abstract class AbstractSoftDeletingDomainEntity extends AbstractDomainEntity implements DomainEntityInterface
{
    protected $deletedAt;

    final public function setDeletedAt(DateTimeInterface $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    final public function getDeletedAt() : ? DateTimeInterface
    {
        return $this->deletedAt;
    }
}
