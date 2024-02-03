<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

interface DomainEntityInterface
{
    public function clearID(): void;

    public function getID(): ?int;

    public function isDirty() : bool;

    public function hashSelf() : string;
}
