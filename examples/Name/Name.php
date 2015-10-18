<?php

namespace Examples\Name;

class Name {
    /** @read-only */
    protected $first;
    /** @read-only */
    protected $middle;
    /** @read-only */
    protected $last;

    public function __construct($first, $middle, $last) {
        $this->first = $first;
        $this->middle = $middle;
        $this->last = $last;
    }

    /** return bool */
    public function equals(Name $name) {
        return (
            $this->first == $name->getFirst() &&
            $this->middle == $name->getMiddle() &&
            $this->last == $name->getLast()
        );
    }

    public function getFirst() {
        return $this->first;
    }
    public function getMiddle() {
        return $this->middle;
    }
    public function getLast() {
        return $this->last;
    }
}