<?php

namespace Arete\Specification;

trait SatisfiedCallable {
    /**
     * @return bool
     */
    public function isSatisfiedBy($object) {
        if (is_callable($this->value)) {
            $callable = $this->value;
            return $callable($object);
        }
        return false;
    }
}
