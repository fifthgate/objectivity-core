<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Collection\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use \Iterator;

interface DomainEntityCollectionInterface extends Iterator
{
    /**
     * Add an item to the collection.
     *
     * @param DomainEntityInterface $domainEntity The Entity to Add
     */
    public function add(DomainEntityInterface $domainEntity): void;

    /**
     * Delete an Item by its key
     *
     * @param  mixed $key The Key of the item.
     * @return void;
     */
    public function delete(mixed $key) : bool;

    /**
     * Is this collection empty?
     *
     * @return boolean true if empty, false if not.
     */
    public function isEmpty() : bool;

    /**
     * Empty the collection
     *
     * @return void
     */
    public function flush(): void;

    /**
    * Sort the collection using usort and a callable (Usuaully a closure)
    *
    * @param callable $sortRoutine A callable routine obeying usort return rules.
    *
    * @return DomainEntityCollectionInterface This collection, as usort works on the original array rather than a copy.
    */
    public function sortCollection(callable $sortRoutine) : DomainEntityCollectionInterface;

    /**
     * Arbitrarily filter the collection using a callable.
     *
     * @param callable $filterRoutine A callable filter routine. Should return TRUE if the item belongs in the collection, false if not. Receives the complete item as a parameter.
     *
     * @return DomainEntityCollectionInterface A freshly filtered collection
     */
    public function filter(callable $filterRoutine) : DomainEntityCollectionInterface;


    /**
     * Slice the array into chunks
     *
     * @param int $length The length of the array
     *
     * @return array the chunked collection
     */
    public function slice(int $length) : array;

    /**
     * Does the collection contain an item with the ID $id?
     *
     * @param int $id The ID to search for
     *
     * @return boolean true if the item is present, false otherwise.
     */
    public function hasID(int $id) : bool;

    /**
     * Get the first item in the collection, as currently sorted.
     *
     * @return DomainEntityInterface|Null The First item in the collection, or null if collection is empty.
     */
    public function first() : ? DomainEntityInterface;

    /**
     * Get the last item in the collection, as currently sorted.
     *
     * @return DomainEntityInterface|null The last item in the collection
     */
    public function last() : ? DomainEntityInterface;

    /**
     * Get the number of items in the collection
     *
     * @return int The number of items in the collection.
     */
    public function count() : int;

    /**
     * Does the collection have an item with this field value?
     *
     * @param string $fieldGetMethodName The name of the Get Method to call to determine the field's value
     * @param string $fieldValue         The value of the field.
     *
     * @return boolean true/false
     */
    public function hasItemWithFieldValue(string $fieldGetMethodName, string $fieldValue) : bool;

    /**
     * Filter the collection for all items with a given field value.
     *
     * @param string $fieldGetMethodName The name of the Get Method to call to determine the field's value
     * @param string $fieldValue         The value of the field.
     *
     * @return DomainEntityCollectionInterface|null A new collection containing only the filtered items, or null if there was no result.
     */
    public function filterByFieldValue(string $fieldGetMethodName, string $fieldValue) : ? DomainEntityCollectionInterface;

    /**
     * Replace an item in the collection by ID
     *
     * @param int                   $entityID     The ID of the entity to be replaced.
     * @param DomainEntityInterface $domainEntity The replacement entity
     *
     * @return void
     */
    public function replace(int $entityID, DomainEntityInterface $domainEntity): void;

    /**
     * Call a method on a collection member.
     *
     * @param int $entityID The entity id
     * @param string $methodName The method name
     * @param array $arguments An array of argument
     *
     * @return bool True if successful, false if not.
     */
    public function call(int $entityID, string $methodName, array $arguments = []) : bool;

    /**
     * Call a method on ALL collection members, if possible.
     *
     * @param string     $methodName     The method name
     * @param array      $arguments      The arguments
     * @param bool       $throwException Whether or not to throw an exception if the call cannot be executed on ANY member,
     *
     * @return bool      True if at least one call was called, false if not.
     */
    public function massCall(string $methodName, array $arguments = [], bool $throwException = false) : bool;

     /**
     * Get an Item from the collection by ID
     *
     * @param int $id The ID to search for.
     *
     * @return DomainEntityInterface|null The Item, or null if not found.
     */
    public function getItemByID(int $id) : ? DomainEntityInterface;

    /**
     * Get the Nth item in the collection as currently sorted.
     *
     * @param  int    $n The value of N.
     * @return DomainEntityInterface|null The Nth Item, or null if no such item exists.
     */
    public function getNth(int $n) : ? DomainEntityInterface;

    /**
     * Get an array of all the Entity IDs currently in the collection.
     * Note, if this collection contains entity of more than one type, there is a possibility of IDs being duplicated.
     * Try filtering y entity type first.
     *
     * @return array An array of IDs
     */
    public function getIDs() : array;

    /**
     * Get a random entry from the collection
     */
    public function random() : ? DomainEntityInterface;

    /**
     * Remove an entity from the collection.
     *
     * @param DomainEntityInterface $item The item to remove from the collection
     *
     * @return bool true if the item was successfully removed, or false if the item was not present in the collection
     */
    public function remove(DomainEntityInterface $item) : bool;

    /**
     * Remove an entity from the collection by id.
     *
     * @param mixed $itemID
     * @return bool true if the item was successfully removed, or false if the item was not present in the collection
     */
    public function removeByID(mixed $itemID) : bool;

    /**
     * Replace an entity by its delta.
     *
     * @param  int                   $delta             The delta to replace.
     * @param  DomainEntityInterface $replacementEntity The replacement entity
     *
     * @return bool                                      True if succesful, false if not.
     */
    public function replaceByDelta(int $delta, DomainEntityInterface $replacementEntity) : bool;
}
