<?php

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\JsonSerializableDomainEntityInterface;

use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\AbstractDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Traits\JsonSerializes;

abstract class AbstractSerializableDomainEntity extends AbstractDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface

{
    use JsonSerializes;
}
