<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

/**
 * Certain domain objects may not come back from their mapper ready to go, relying instead on subsequent services inside the find method to populate them.
 * This interface specifies a standardised way for objects to store 'shadow' values prior to population. For example, the 'Event' object may have a 'host' value that it expects to be hydrated at the surface layer. You can set the shadowvalue 'host_id' through this method and then recover it to pass to the Host Service.
 */
interface ShadowsValuesInterface
{
    /**
     * Sets a shadow value.
     **/
    public function setShadowValue(string $shadowName, $value): void;

    /**
     *  Gets a shadow value
     */
    public function getShadowValue(string $shadowName);

    /**
     * Tests if a value is shadowable for this entity.
     */
    public function isShadowableValue(string $shadowName) : bool;

    /**
     * Clears a shadow value once it's of no further use.
     */
    public function clearShadowValue(string $shadowName) : void;
}
