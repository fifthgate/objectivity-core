<?php

namespace Fifthgate\Objectivity\Domain\Interfaces;

use \DateTimeInterface;

interface DomainEntityInterface
{
    public function getID() : ?int;
}
