<?php

namespace Ares\ValidationObject;

use InvalidArgumentException;

readonly class EconomicallySubjectName {
    public string $economicallySubjectName;

    public function __construct(string $economicallySubjectName) {
        if ($this->isValid($economicallySubjectName) === false) {
            throw new InvalidArgumentException('Subject name is invalid');
        }

        $this->economicallySubjectName = $economicallySubjectName;
    }

    private function isValid(string $economicallySubjectName): bool
    {
        return strlen($economicallySubjectName);
    }
}