<?php

namespace Fifthgate\Objectivity\Core\Domain\Collection\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \Iterator;

interface DomainEntityCollectionInterface extends Iterator
{
    public function add(DomainEntityInterface $domainEntity);

    public function delete($key) : bool;

    public function isEmpty() : bool;

    public function flush();

    public function sortCollection(callable $sortRoutine) : DomainEntityCollectionInterface;

    public function filter(callable $filterRoutine) : DomainEntityCollectionInterface;

    public function slice(int $length) : array;

    public function hasID(int $id) : bool;

    public function first() : ? DomainEntityInterface;

    public function last() : ? DomainEntityInterface;

    public function count() : int;

    public function hasItemWithFieldValue(string $fieldGetMethodName, string $fieldValue) : bool;

    public function filterByFieldValue(string $fieldGetMethodName, string $fieldValue) : ? DomainEntityCollectionInterface;

    public function replace(int $entityID, DomainEntityInterface $domainEntity);

    public function call(int $entityID, string $methodName, ? array $arguments) : bool;

    public function massCall(string $methodName, ? array $arguments, bool $throwException = false) : bool;
}
