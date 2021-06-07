<?php

namespace Fifthgate\Objectivity\Core\Domain\Collection;

use \Iterator;

/**
 * An abstract iterator, useless on its own but useful for avoiding duplication of effort.
 */
abstract class AbstractIterator implements Iterator
{
    protected $collection = [];

    protected $position;

    //@codeCoverageIgnoreStart
    /**
     * Create a new instance
     *
     * @param array $collection An array of items to form the collection. Optional.
     *
     * @return void
     */
    public function __construct(array $collection = [])
    {
        $this->position = 0;
        if (!empty($collection)) {
            $this->collection = $collection;
        }
    }
    //@codeCoverageIgnoreEnd

    /**
     * Reset the internal pointer position.
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Get the item in the current position.
     *
     * @return DomainEntityInterface
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     * Get the current position
     *
     * @return mixed position
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Advance iterator to new item
     *
     * @return void
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Is the attempted delta valid?
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

    /**
     * Delete an item from the collection
     *
     * @param int $key The delta of the item to be deleted.
     *
     * @return bool True if sucessfully deleted, false otherwise.
     */
    public function delete($key) : bool
    {
        if (isset($this->collection[$key])) {
            unset($this->collection[$key]);
            return true;
        }
        return false;
    }

     /**
     * Is this collection empty?
     *
     * @return boolean True or false
     */
    public function isEmpty() : bool
    {
        return empty($this->collection);
    }

     /**
     * Empty the collection
     *
     * @return void
     */
    public function flush()
    {
        $this->collection = [];
    }

    
    /**
     * Get the number of items in the collection
     *
     * @return int The number of items in the collection.
     */
    public function count() : int
    {
        $i = 0;
        foreach ($this->collection as $item) {
            $i++;
        }
        return $i;
    }
}
