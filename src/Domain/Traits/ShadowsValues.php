<?php

namespace Fifthgate\Objectivity\Core\Domain\Traits;

use Fifthgate\Objectivity\Core\Domain\Interfaces\ShadowsValuesInterface;
use Fifthgate\Objectivity\Core\Domain\Exceptions\ShadowValueException;

trait ShadowsValues
{
    protected array $shadowValues = [];

    final public function setShadowValue(string $shadowName, $value)
    {
        if ($this->isShadowableValue($shadowName)) {
            $this->shadowValues[$shadowName] = $value;
        } else {
            throw new ShadowValueException("'{$shadowName}' is not a shadowable value!");
        }
    }

    final public function getShadowValue(string $shadowName)
    {
        if ($this->isShadowableValue($shadowName)) {
            return $this->shadowValues[$shadowName] ?? null;
        }
        throw new ShadowValueException("'{$shadowName}' is not a shadowable value!");
    }

    /**
     * Clears a shadow value once it's of no further use.
     */
    final public function clearShadowValue(string $shadowName) : void
    {
        if ($this->isShadowableValue($shadowName)) {
            if (isset($this->shadowValues[$shadowName])) {
                unset($this->shadowValues[$shadowName]);
            }
        } else {
            throw new ShadowValueException("'{$shadowName}' is not a shadowable value!");
        }
    }

    abstract public function isShadowableValue(string $shadowName) : bool;
}
