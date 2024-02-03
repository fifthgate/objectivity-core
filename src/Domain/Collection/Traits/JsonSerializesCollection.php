<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Core\Domain\Collection\Traits;

use JsonSerializable;

trait JsonSerializesCollection 
{
    public function jsonSerialize(): array
    {
        $returnArray = [];
        foreach ($this->collection as $item) {
            if ($item instanceof JsonSerializable) {
                $returnArray[] = $item->jsonSerialize();
            }
        }
        
        return $returnArray;
    }
}