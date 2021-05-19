<?php

namespace Fifthgate\Objectivity\Core\Domain\Collection\Traits;

use JsonSerializable;

trait JsonSerializesCollection 
{
    public function jsonSerialize() {
        $returnArray = [];
        foreach ($this->collection as $item) {
            if ($item instanceof JsonSerializable) {
                $returnArray[] = $item->jsonSerialize();
            }
        }
        
        return $returnArray;
    }
}