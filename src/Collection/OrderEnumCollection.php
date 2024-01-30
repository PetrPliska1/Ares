<?php

namespace YourNamespace\Collection;

use YourNamespace\Enum\OrderEnum;

class OrderEnumCollection
{
    /** @var array<int,OrderEnum> */
    private array $orderEnums = [];

    public function add(OrderEnum $orderEnum): static
    {
        $this->orderEnums[] = $orderEnum;

        return $this;
    }

    public function getOrderEnumValues(): array
    {
        return array_map(fn(OrderEnum $enum) => $enum->value, $this->orderEnums);
    }
}