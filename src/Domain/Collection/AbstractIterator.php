<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Collection;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \Iterator;
use ReturnTypeWillChange;

/**
 * An abstract iterator, useless on its own but useful for avoiding duplication of effort.
 */
abstract class AbstractIterator implements Iterator, \Countable
{
    protected array $collection = [];

    protected int $position;

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
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Get the item in the current position.
     *
     * @return DomainEntityInterface
     */
    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    /**
     * Get the current position
     *
     * @return mixed position
     */
    #[ReturnTypeWillChange] public function key(): mixed
    {
        return $this->position;
    }

    /**
     * Advance iterator to new item
     *
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Is the attempted delta valid?
     *
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    /**
     * Delete an item from the collection
     *
     * @param mixed $key The delta of the item to be deleted.
     *
     * @return bool True if successfully deleted, false otherwise.
     */
    public function delete(mixed $key) : bool
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
    public function flush(): void
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
        return count($this->collection);
    }
}
