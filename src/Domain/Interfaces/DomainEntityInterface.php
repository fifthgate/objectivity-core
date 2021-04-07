<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use \DateTimeInterface;

interface DomainEntityInterface
{
    public function getID();

    public function isDirty() : bool;

    public function hashSelf() : string;
}
