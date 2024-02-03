<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use \DateTimeInterface;

interface SoftDeletingDomainEntityInterface extends DomainEntityInterface
{
    public function getDeletedAt() : ? DateTimeInterface;

    public function setDeletedAt(DateTimeInterface $deletedAt);
}
