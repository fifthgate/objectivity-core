<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Traits\JsonSerializes;
use JsonSerializable;

abstract class AbstractSerializableDomainEntity extends AbstractSoftDeletingDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface, JsonSerializable

{
    use JsonSerializes;
}
