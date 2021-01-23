<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use \DateTimeInterface;

interface TimestampingDomainEntityInterface
{
    public function setCreatedAt(DateTimeInterface $createdAt);
    public function getCreatedAt() : DateTimeInterface;

    public function setUpdatedAt(DateTimeInterface $updatedAt);
    public function getUpdatedAt() : DateTimeInterface;
}
