<?php

namespace Arete\Specification;

/**
 * The XOR of two other Specifications.
 */
class XorSpecification extends AbstractCombinationSpecification implements Specification {
    /**
     * @return bool
     */
    public function isSatisfiedBy($object) {
        return $this->specificationOne->isSatisfiedBy($object) xor $this->specificationTwo->isSatisfiedBy($object);
    }
}