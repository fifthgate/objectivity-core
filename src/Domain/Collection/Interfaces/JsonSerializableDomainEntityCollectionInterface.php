<?php

namespace Fifthgate\Objectivity\Core\Domain\Collection\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use JsonSerializable;

interface JsonSerializableDomainEntityCollectionInterface extends DomainEntityCollectionInterface, JsonSerializable
{
}
