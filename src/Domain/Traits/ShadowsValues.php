<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Traits;

use Fifthgate\Objectivity\Core\Domain\Traits\Exceptions\ShadowValueException;

trait ShadowsValues
{
    protected array $shadowValues = [];

    /**
     * @param string $shadowName
     * @param $value
     *
     * @return void
     *
     * @throws ShadowValueException
     */
    final public function setShadowValue(string $shadowName, $value): void
    {
        if ($this->isShadowableValue($shadowName)) {
            $this->shadowValues[$shadowName] = $value;
        } else {
            throw new ShadowValueException("'{$shadowName}' is not a shadowable value!");
        }
    }

    /**
     * @param string $shadowName
     *
     * @return mixed|null
     *
     * @throws ShadowValueException
     */
    final public function getShadowValue(string $shadowName): mixed
    {
        if ($this->isShadowableValue($shadowName)) {
            return $this->shadowValues[$shadowName] ?? null;
        }
        throw new ShadowValueException("'{$shadowName}' is not a shadowable value!");
    }

    /**
     * Clears a shadow value once it's of no further use.
     * @throws ShadowValueException
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
