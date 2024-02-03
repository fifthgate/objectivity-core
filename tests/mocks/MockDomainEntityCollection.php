<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Tests\Mocks;

use Fifthgate\Objectivity\Core\Domain\AbstractSoftDeletingDomainEntity;
use Fifthgate\Objectivity\Core\Domain\Collection\AbstractDomainEntityCollection;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\JsonSerializableDomainEntityCollectionInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Traits\JsonSerializesCollection;

class MockDomainEntityCollection extends AbstractDomainEntityCollection implements JsonSerializableDomainEntityCollectionInterface {
    use JsonSerializesCollection;   
}