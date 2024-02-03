<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

use JsonSerializable;

interface JsonSerializableDomainEntityInterface extends DomainEntityInterface, JsonSerializable
{
}
