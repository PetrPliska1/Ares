<?php

namespace YourNamespace\Collection;

use YourNamespace\ValidationObject\Ico;

class IcoCollection
{
    /** @var array<int,Ico> */
    private array $icos = [];

    public function add(Ico $ico): static
    {
        $this->icos[] = $ico;

        return $this;
    }

    public function getIcoValues(): array
    {
        return array_map(fn(Ico $ico) => $ico->ico, $this->icos);
    }
}