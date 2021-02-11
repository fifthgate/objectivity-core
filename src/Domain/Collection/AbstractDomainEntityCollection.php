<?php

namespace Fifthgate\Objectivity\Core\Domain\Collection;

use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;


abstract class AbstractDomainEntityCollection implements DomainEntityCollectionInterface
{
    protected $collection = [];

    protected $position;

    //@codeCoverageIgnoreStart
    public function __construct(array $collection = [])
    {
        $this->position = 0;
        if (!empty($collection)) {
            $this->collection = $collection;
        }
    }
    //@codeCoverageIgnoreEnd

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

    public function add(DomainEntityInterface $domainEntity)
    {
        $this->collection[] = $domainEntity;
    }

    public function delete($key) : bool
    {
        if (isset($this->collection[$key])) {
            unset($this->collection[$key]);
            return true;
        }
        return false;
    }

    public function isEmpty() : bool
    {
        return empty($this->collection);
    }

    public function flush()
    {
        $this->collection = [];
    }

    public function sortCollection(callable $sortRoutine) : DomainEntityCollectionInterface
    {
        usort($this->collection, $sortRoutine);
        return $this;
    }

    public function filter(callable $filterRoutine) : DomainEntityCollectionInterface
    {
        $filteredCollection = new $this;
        foreach ($this->collection as $item) {
            if ($filterRoutine($item)) {
                $filteredCollection->add($item);
            }
        }
        return $filteredCollection;
    }

    public function slice(int $length) : array
    {
        return array_chunk($this->collection, $length);
    }

    public function getFirstN(int $length) {
        $collection = new $this;
        $items = $this->slice($length);
        $items = reset($items);
        foreach ($items as $item) {
            $collection->add($item);
        }
        return $collection;
    }

    public function hasID(int $id) :bool
    {
        foreach ($this->collection as $item) {
            if ($item->getID() == $id) {
                return true;
            }
        }
        return false;
    }

    public function first() : ? DomainEntityInterface
    {
        $unsortedCollection = $this->collection;
        $unsortedCollection = array_reverse($unsortedCollection);
        $item = array_pop($unsortedCollection);
        if ($item instanceof DomainEntityInterface) {
            return $item;
        }
        return null;
    }

    public function last() : ? DomainEntityInterface
    {
        $unsortedCollection = $this->collection;
        $item = array_pop($unsortedCollection);
        if ($item instanceof DomainEntityInterface) {
            return $item;
        }
        return null;
    }

    public function count() : int
    {
        $i = 0;
        foreach ($this->collection as $item) {
            $i++;
        }
        return $i;
    }

    public function hasItemWithFieldValue(string $fieldGetMethodName, string $fieldValue) : bool {
        foreach ($this->collection as $item) {
            if (!method_exists($item, $fieldGetMethodName)) {
                continue;
            }
            if ($item->$fieldGetMethodName() == $fieldValue) {
                return true;
            }
        }
        return false;
    }
}
 