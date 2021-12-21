<?php
/**
 * A simple trait to fluff json serialization in the absence of something better.
 *
 * @category ValueObject
 * @package  Objectivity Core
 * @author   Sam Baynham <sam@fifthgate.net>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/fifthgate/objectivity-core
 * @since    2021
 */
namespace Fifthgate\Objectivity\Core\Domain\Traits;

use ReflectionMethod;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\JsonSerializableDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\JsonSerializableDomainEntityCollectionInterface;
use JsonSerializable;

/**
 * Json Serialization trait for objectivity-compatible Domain Entities.
 *
 * @category ValueObject
 * @package  Objectivity Core
 * @author   Sam Baynham <sam@fifthgate.net>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/fifthgate/objectivity-core
 * @since    2021
 */
trait JsonSerializes
{
    /**
     * Serialize the object to an array.
     *
     * @return array An array of object variables, based on get methods.
     */
    public function jsonSerialize($excludedMethods = [])
    {

        $defaultExcludedMethods = [
            "getID",
            "getCreatedAt",
            "getUpdatedAt",
            "getUpdatedAt",
            "getShadowValue",
            "getDeletedAt"
        ];
        foreach ($defaultExcludedMethods as $defaultExcludedMethod) {
            if (!in_array($defaultExcludedMethod, $excludedMethods)) {
                $excludedMethods[] = $defaultExcludedMethod;
            }
        }
        $methods = get_class_methods($this);
        
        $jsonArray = [
            "id" => $this->getID()
        ];
        if (property_exists($this, "createdAt") && isset($this->createdAt) && $this->createdAt != null) {
            $jsonArray['created_at'] = $this->createdAt->format('Y-m-d H:i:s');
        }
        if (property_exists($this, "updatedAt") && isset($this->updatedAt) && $this->updatedAt != null) {
            $jsonArray['updated_at'] = $this->updatedAt->format('Y-m-d H:i:s');
        }
        if (property_exists($this, "deletedAt") && isset($this->deletedAt) && $this->deletedAt != null) {
            $jsonArray['deleted_at'] = $this->deletedAt->format('Y-m-d H:i:s');
        }
        foreach ($methods as $methodName) {
            //Check if method begins with 'get';
            if (substr($methodName, 0, 3) === "get" && !in_array($methodName, $excludedMethods)) {
                $reflection = new ReflectionMethod($this, $methodName);
                if ($reflection->isPublic()) {
                    $jsonArray[$this->arrayifyName($methodName)] = $this->serializeValue($this->$methodName());
                }
            }
        }
        
        
        ksort($jsonArray);
        return $jsonArray;
    }

    /**
     * Turn a 'StudlyMethodName' into a 'studly_method_name' for use as an array key.
     *
     * @param string $methodName The studly method name.
     *
     * @return string The newly de-studified method name.
     */
    protected function arrayifyName(string $methodName) : string
    {
        $trimmedName = substr($methodName, 3, strlen($methodName)-3);
        
        $studlyArray =  preg_split('/(?=[A-Z])/', $trimmedName);
        //Clear the first bit off.
        unset($studlyArray[0]);
        
        $studlyArray = array_values($studlyArray);
        $finalName = "";

        //@codeCoverageIgnoreStart
        for ($i = 0; $i < count($studlyArray); $i++) {
            $finalName .= strtolower($studlyArray[$i]);

            if ($i < count($studlyArray)-1) {
                $finalName .= "_";
            }
        }
        //@codeCoverageIgnoreEnd
        return $finalName;
    }

    //@codeCoverageIgnoreStart
    /**
     * Serializes a value for use in an array.
     *
     * @param mixed $value The value to serialize
     *
     * @return mixed The serialized value, if serialized it can, in fact, be.
     */
    protected function serializeValue($value)
    {
        if (is_string($value) || is_numeric($value)) {
            return $value;
        }
        
        if (is_array($value)) {
            ksort($value);
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if ($value instanceof JsonSerializable) {
            return $value->jsonSerialize();
        }
    }
    //@codeCoverageIgnoreEnd
}
