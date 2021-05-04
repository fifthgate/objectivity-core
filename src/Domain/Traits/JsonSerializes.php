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
    public function jsonSerialize()
    {
        $methods = get_class_methods($this);
        $jsonArray = [
            "id" => $this->getID()
        ];
        foreach ($methods as $methodName) {
            //Check if method begins with 'get';
            if (substr($methodName, 0, 3) === "get" && $methodName !== "getID") {
                $reflection = new ReflectionMethod($this, $methodName);
                if ($reflection->isPublic()) {
                    $jsonArray[$this->arrayifyName($methodName)] = $this->serializeValue($this->$methodName());
                }
                
            }
        }
        
        
        ksort($jsonArray);
        return $jsonArray;
    }

    protected function arrayifyName(string $methodName) : string
    {
        $trimmedName = substr($methodName, 3, strlen($methodName)-3);
        
        $studlyArray =  preg_split('/(?=[A-Z])/', $trimmedName);
        //Clear the first bit off.
        unset($studlyArray[0]);
        
        $studlyArray = array_values($studlyArray);
        $finalName = "";

        for (
            $i = 0;
            $i < count($studlyArray);
            $i++
        ) {
            $finalName .= strtolower($studlyArray[$i]);

            if ($i < count($studlyArray)-1) {
                $finalName .= "_";
            }
        }
        return $finalName;
    }

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
}