<?php

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\AbstractDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\SoftDeletingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Traits\SoftDeletes;

abstract class AbstractSoftDeletingDomainEntity extends AbstractDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface, SoftDeletingDomainEntityInterface
{
    use SoftDeletes;
}
