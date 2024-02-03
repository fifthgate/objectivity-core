<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

interface SluggableDomainEntityInterface extends DomainEntityInterface
{
    public function getSlug() : string;

    public function setSlug(string $slug);
}
