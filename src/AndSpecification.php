<?php

namespace Arete\Specification;

/**
 * AND specification, used to create a new specifcation that is the AND of two other specifications.
 */
class AndSpecification extends AbstractCombinationSpecification implements Specification {    
    /**
     * @return bool
     */
    public function isSatisfiedBy($object) {       
        return $this->specificationOne->isSatisfiedBy($object) && $this->specificationTwo->isSatisfiedBy($object);
    }
}
