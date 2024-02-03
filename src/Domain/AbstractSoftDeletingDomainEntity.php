<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\TimestampingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\SoftDeletingDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Traits\SoftDeletes;

abstract class AbstractSoftDeletingDomainEntity extends AbstractDomainEntity implements DomainEntityInterface, TimestampingDomainEntityInterface, SoftDeletingDomainEntityInterface
{
    use SoftDeletes;
}
