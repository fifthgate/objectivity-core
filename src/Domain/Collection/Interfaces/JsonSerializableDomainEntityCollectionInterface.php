<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Collection\Interfaces;

use JsonSerializable;

interface JsonSerializableDomainEntityCollectionInterface extends DomainEntityCollectionInterface, JsonSerializable
{
}
