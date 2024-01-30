<?php

namespace YourNamespace\ValidationObject;

use InvalidArgumentException;

readonly class SubjectsPerPage {
    public string $subjectsPerPage;

    public function __construct(int $subjectsPerPage) {
        if ($this->isValid($subjectsPerPage) === false) {
            throw new InvalidArgumentException('Subject per page must be greater than 0 and lower or equal 10000');
        }

        $this->subjectsPerPage = $subjectsPerPage;
    }

    private function isValid(string $subjectsPerPage): bool
    {
        return $subjectsPerPage > 0 && $subjectsPerPage <= 10000;
    }
}