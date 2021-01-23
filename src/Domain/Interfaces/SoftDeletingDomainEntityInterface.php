<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

interface SoftDeletingDomainEntityInterface extends DomainEntityInterface
{
    public function getDeletedAt() : ? DateTimeInterface;

    public function setDeletedAt(DateTimeInterface $deletedAt);
}
