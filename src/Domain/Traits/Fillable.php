<?php

/**
 * A trait to enable filling of an object from an array.
 *
 * @category ValueObject
 * @package  Objectivity Core
 * @author   Sam Baynham <sam@fifthgate.net>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/fifthgate/objectivity-core
 * @since    2021
 */
namespace Fifthgate\Objectivity\Core\Domain\Traits;

use Fifthgate\Objectivity\Core\Domain\Traits\Exceptions\FillableInvalidValueException;
use Fifthgate\Objectivity\Core\Domain\Interfaces\FillableInterface;
use ReflectionProperty;
use ReflectionMethod;
use \DateTime;

trait Fillable {

    public static function fill(array $values) : FillableInterface
    {
        $filledItem = new self;
        $hasErrors = false;
        $errors = [];

        foreach ($values as $propertyName => $value) {
            //1: Determine if a property has a setter we can use.
            //2: Determine if the value we have will be accepted by the setter without modification.
            //3: If YES, set the value using the setter.
            //4: If NO, try this routine:
            // 4b: Is the typed property a date, and is our value a string that can be evaluated to a date? If so, create a date from our value and call the setter.
            //4c: If our Setter can't be called with the given value, throw an exception.
            $separator = '_';

            //1:
            $camelCasePropertyName = str_replace($separator, '', ucwords($propertyName, $separator));
            $candidateSetterName = "set{$camelCasePropertyName}";
            
            try {
                self::validateFill($filledItem, $candidateSetterName, $propertyName, $value);
            } catch (FillableInvalidValueException $e) {
                $hasErrors = true;
                $errors[] = $e->getMessage();
            }

            if ($hasErrors) {
                $errorString = '';
                foreach ($errors as $error) {
                    $errorString.="{$error} \n";
                }
                throw new FillableInvalidValueException($errorString);
            }
            
            if (self::determineParameterType($filledItem, $propertyName, $candidateSetterName) == 'DateTimeInterface' && is_string($value)) {
                $filledItem->$candidateSetterName(new DateTime($value));
            } else {
                $filledItem->$candidateSetterName($value);    
            }
        }
        return $filledItem;
    }

    protected static function determineParameterType(FillableInterface $filledItem, string $propertyName, string $setterName) : ? string
    {
        $r = new ReflectionMethod($filledItem, $setterName);
        $parameters = $r->getParameters();
        $firstParameter = reset($parameters);
        if (!$r->isPublic()) {
            throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' whose setter, '{$setterName}' is not public");
        }
        $parameterCount = $r->getNumberOfRequiredParameters();
        if ($parameterCount > 1) {
            throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' whose setter, '{$setterName}' requires {$parameterCount} parameters");   
        }
        $parameters = $r->getParameters();
        $firstParameter = reset($parameters);
        return $firstParameter->getType()->getName();
    }

    protected static function validateFill(FillableInterface $filledItem, string $candidateSetterName, $propertyName, $value)
    {
        if (method_exists($filledItem, $candidateSetterName)) {
            //2
            $parameterType = self::determineParameterType($filledItem, $propertyName, $candidateSetterName);
            switch ($parameterType) {
                case 'int':
                    if (!is_int($value)) {
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not an integer.");
                    }
                    break;
                case 'bool':
                    if (!is_bool($value)) {
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not a boolean.");
                    }
                    break;
                case 'string':
                    if (!is_string($value)) {
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not a string.");
                    }
                    break;
                case 'array':
                    if (!is_array($value)) {
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not an array.");
                    }
                    break;
                case 'float':
                    if (!is_float($value)) {
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not a float.");
                    }
                    break;
                case 'DateTimeInterface':
                    if (
                        (is_object($value) && !($value instanceof DateTimeInterface))
                        or
                        (is_string($value) && !strtotime($value))
                    ) {
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not a DateTimeInterface or a parseable date string.");
                    }
                    break;
                default:
                    if (!$value instanceof $parameterType) {
                        //Catch-all
                        throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' with a value that is not of the correct type.");    
                    }
                    break;
            }
        } else {
            throw new FillableInvalidValueException("You are attempting to fill a value, '{$propertyName}' which does not posess a valid setter method.");
        }
    }
}