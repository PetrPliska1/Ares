<?php

namespace Ares\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Ares\Data\EconomicallySubject;

class EconomicallySubjectCollection implements IteratorAggregate, Countable, ArrayAccess
{
    /** @var array<int,EconomicallySubject> */
    private array $subjects = [];

    public function add(EconomicallySubject $subject): void
    {
        $this->subjects[] = $subject;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->subjects);
    }

    public function count(): int
    {
        return count($this->subjects);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->subjects[$offset]);
    }

    public function offsetGet($offset): ?EconomicallySubject
    {
        return $this->offsetExists($offset) ? $this->subjects[$offset] : null;
    }

    public function offsetSet($offset, $value): void
    {
        if ($value instanceof EconomicallySubject) {
            $this->subjects[$offset] = $value;
        } else {
            throw new InvalidArgumentException('Value must be an instance of EconomicallySubject');
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->subjects[$offset]);
    }
}