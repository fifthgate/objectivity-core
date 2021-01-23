<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;

interface SluggableDomainEntityInterface extends DomainEntityInterface
{
    public function getSlug() : string;

    public function setSlug(string $slug) : string;
}
