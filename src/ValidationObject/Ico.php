<?php
namespace YourNamespace\ValidationObject;

use InvalidArgumentException;

readonly class Ico {
    public string $ico;

    public function __construct(string $ico) {
        if ($this->isValid($ico) === false) {
            throw new InvalidArgumentException('Ico is invalid');
        }

        $this->ico = $ico;
    }

    /**
     * Algorithm inspired by https://phpfashion.com/jak-overit-platne-ic-a-rodne-cislo
     */
    private function isValid(string $ico): bool
    {
        // be liberal in what you receive
        $ico = preg_replace('#\s+#', '', $ico);

        // is in required form?
        if (!preg_match('#^\d{8}$#', $ico)) {
            return false;
        }

        // checksum
        $a = 0;
        for ($i = 0; $i < 7; $i++) {
            $a += $ico[$i] * (8 - $i);
        }

        $a %= 11;
        if ($a === 0) {
            $c = 1;
        } elseif ($a === 1) {
            $c = 0;
        } else {
            $c = 11 - $a;
        }

        return (int) $ico[7] === $c;
    }
}