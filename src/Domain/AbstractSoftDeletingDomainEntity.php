<?php

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\AbstractDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\SoftDeletingDomainEntityInterface;


abstract class AbstractSoftDeletingDomainEntity extends AbstractDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface, SoftDeletingDomainEntityInterface
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
