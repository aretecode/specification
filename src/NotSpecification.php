<?php

namespace Arete\Specification;

/**
 * NOT decorator, used to create a new specifcation that is the inverse (NOT) of the given spec.
 * 
 * Create a new NOT specification based on another spec.
 *
 * @param specification Specification instance to not.
 */
class NotSpecification extends AbstractSpecification implements Specification { 
    protected $specification;

    /**
     * Create a new NOT specification based on another spec.
     *
     * @param Specification $specification instance to not.
     */
    public function __construct($specification) {
        $this->specification = $specification;
    }

    /**
     * return bool
     */
    public function isSatisfiedBy($object) {
        return !$this->specification->isSatisfiedBy($object);
    }
}
