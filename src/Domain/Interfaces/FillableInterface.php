<?php

namespace Fifthgate\Objectivity\Core\Domain\Interfaces;

interface FillableInterface
{
    public static function fill(array $value) : FillableInterface;
}
