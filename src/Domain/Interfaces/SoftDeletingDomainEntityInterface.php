<?php

namespace Fifthgate\Objectivity\Domain\Interfaces;

use \DateTimeInterface;
use Fifthgate\Objectivity\Domain\Interfaces\DomainEntityInterface;

interface SoftDeletingDomainEntityInterface extends DomainEntityInterface
{
    public function getDeletedAt() : ? DateTimeInterface;

    public function setDeletedAt(DateTimeInterface $deletedAt);
}
