<?php

namespace Arete\Specification;

/**
 * The OR of two other specifications.
 */
class OrSpecification extends AbstractCombinationSpecification implements Specification {
    /**
     * return bool
     */
    public function isSatisfiedBy($object) {
        return $this->specificationOne->isSatisfiedBy($object) || $this->specificationTwo->isSatisfiedBy($object);
    }
}