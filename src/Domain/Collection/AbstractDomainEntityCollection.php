<?php

namespace Fifthgate\Objectivity\Core\Domain\Collection;

use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Exceptions\InvalidMassCallException;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\AbstractIterator;

abstract class AbstractDomainEntityCollection extends AbstractIterator implements DomainEntityCollectionInterface
{
    protected $collection = [];

    protected $position;

    /**
     * Add an item to the end of the colleciton
     *
     * @param DomainEntityInterface $domainEntity The item to be added
     *
     * @return void
     */
    public function add(DomainEntityInterface $domainEntity)
    {
        $this->collection[] = $domainEntity;
    }

    /**
     * Sort the collection using usort and a callable (Usuaully a closure)
     *
     * @param callable $sortRoutine A callable routine obeying usort return rules.
     *
     * @return DomainEntityCollectionInterface This collection, as usort works on the original array rather than a copy.
     */
    public function sortCollection(callable $sortRoutine) : DomainEntityCollectionInterface
    {
        usort($this->collection, $sortRoutine);
        return $this;
    }

    /**
     * Arbitrarily filter the collection using a callable.
     *
     * @param callable $filterRoutine A callable filter routine. Should return TRUE if the item belongs in the collection, false if not. Receives the complete item as a parameter.
     *
     * @return DomainEntityCollectionInterface A freshly filtered collection
     */
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

    /**
     * Slice the array into chunks
     *
     * @param int $length The length of the array
     *
     * @return array the chunked collection
     */
    public function slice(int $length) : array
    {
        return array_chunk($this->collection, $length);
    }

    /**
     * Get the first N items in the collection as currently sorted.
     *
     * @param int $length How many items do you want?
     *
     * @return array The first n items in the collection.
     */
    public function getFirstN(int $length)
    {
        $collection = new $this;
        $items = $this->slice($length);
        $items = reset($items);
        if (!empty($items)) {
            foreach ($items as $item) {
                $collection->add($item);
            }
        }
        
        return $collection;
    }

    /**
     * Does the collection contain an item with the ID $id?
     *
     * @param int $id The ID to search for
     *
     * @return boolean true if the item is present, false otherwise.
     */
    public function hasID(int $id) :bool
    {
        foreach ($this->collection as $item) {
            if ($item->getID() == $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the first item in the collection, as currently sorted.
     *
     * @return DomainEntityInterface|Null The First item in the collection, or null if collection is empty.
     */
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

    /**
     * Get the last item in the collection, as currently sorted.
     *
     * @return DomainEntityInterface The last item in the collection
     */
    public function last() : ? DomainEntityInterface
    {
        $unsortedCollection = $this->collection;
        $item = array_pop($unsortedCollection);
        if ($item instanceof DomainEntityInterface) {
            return $item;
        }
        return null;
    }

    /**
     * Does the collection have an item with this field value?
     *
     * @param string $fieldGetMethodName The name of the Get Method to call to determine the field's value
     * @param string $fieldValue         The value of the field.
     *
     * @return boolean true/false
     */
    public function hasItemWithFieldValue(string $fieldGetMethodName, string $fieldValue) : bool
    {
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

    /**
     * Filter the collection for all items with a given field value.
     *
     * @param string $fieldGetMethodName The name of the Get Method to call to determine the field's value
     * @param string $fieldValue         The value of the field.
     *
     * @return DomainEntityCollectionInterface|null A new collection containing only the filtered items, or null if there was no result.
     */
    public function filterByFieldValue(string $fieldGetMethodName, string $fieldValue) : ? DomainEntityCollectionInterface
    {
        $filteredCollection = new $this;
        foreach ($this->collection as $item) {
            if (!method_exists($item, $fieldGetMethodName)) {
                continue;
            }
            if ($item->$fieldGetMethodName() == $fieldValue) {
                $filteredCollection->add($item);
            }
        }
        return $filteredCollection->count() > 0 ? $filteredCollection : null;
    }

    /**
     * Replace an item in the collection by ID
     *
     * @param int                   $entityID     The ID of the entity to be replaced.
     * @param DomainEntityInterface $domainEntity The replacement entity
     *
     * @return void
     */
    public function replace(int $entityID, DomainEntityInterface $domainEntity)
    {
        foreach ($this->collection as $delta => $item) {
            if ($item->getID() == $entityID && $item->getID() !== 0) {
                $this->collection[$delta] = $domainEntity;
            }
        }
    }

    /**
     * Call a method on a collection member.
     *
     * @param int        $entityID   The entity id
     * @param string     $methodName The method name
     * @param array|null $arguments  An array of argument
     *
     * @return bool True if succesful, false if not.
     */
    public function call(int $entityID, string $methodName, ? array $arguments) : bool
    {
        foreach ($this->collection as &$item) {
            if ($item->getID() == $entityID) {
                if (method_exists($item, $methodName)) {
                    call_user_func_array([$item, $methodName], $arguments);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Call a method on ALL collection members, if possible.
     *
     * @param string     $methodName     The method name
     * @param array      $arguments      The arguments
     * @param bool       $throwException Whether or not to throw an exception if the call cannot be executed on ANY member,
     *
     * @return bool      True if at least one call was called, false if not.
     */
    public function massCall(string $methodName, array $arguments = [], bool $throwException = false) : bool
    {
        $hasCalled = false;
        if (!empty($this->collection)) {
            foreach ($this->collection as &$item) {
                if (method_exists($item, $methodName)) {
                    call_user_func_array([$item, $methodName], !empty($arguments) ? $arguments : null);
                    $hasCalled = true;
                }
            }
            if ($throwException && !$hasCalled) {
                throw new InvalidMassCallException;
            }
        }
        
        return $hasCalled;
    }

    /**
     * Get an Item from the collection by ID
     *
     * @param int $id The ID to search for.
     *
     * @return DomainEntityInterface|null The Item, or null if not found.
     */
    public function getItemByID(int $id) : ? DomainEntityInterface
    {
        foreach ($this->collection as $item) {
            if ($item->getID() != null && (int) $item->getID() === $id) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Get the Nth item in the collection as currently sorted.
     *
     * @param  int    $n The value of N.
     * @return DomainEntityInterface|null The Nth Item, or null if no such item exists.
     */
    public function getNth(int $n) : ? DomainEntityInterface
    {
        $i = 1;
        foreach ($this->collection as $item) {
            if ($i == $n) {
                return $item;
            }
            $i++;
        }
        return null;
    }

    /**
     * Get an array of all the Entity IDs currently in the collection.
     * Note, if this collection contains entity of more than one type, there is a possibility of IDs being duplicated.
     * Try filtering y entity type first.
     *
     * @return array An array of IDs
     */
    public function getIDs() : array
    {
        $ids = [];
        foreach ($this->collection as $item) {
            $ids[] = $item->getID();
        }
        return $ids;
    }

    /**
     * Get a random entry from the collection
     */
    public function random() : ? DomainEntityInterface
    {
        if (!$this->isEmpty()) {
            $randomKey = array_rand($this->collection);
            return $this->collection[$randomKey];
        }
        return null;
        
    }
}
