<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use JsonSerializable;

interface JsonSerializableDomainEntityInterface extends DomainEntityInterface, JsonSerializable
{
}
