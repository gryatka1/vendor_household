<?php

namespace VendorHousehold\DTO\Traits;

trait JsonSerializableTrait
{
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
