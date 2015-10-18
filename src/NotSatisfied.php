<?php

namespace Arete\Specification;

trait NotSatisfied {
    /**
     * @var array<Specification, Specification)
     */
    protected $notSatisfied = [];

    /**
     * adds it to $this->notSatisfied if it does not match
     * 
     * @param  Specification $specification 
     * @param  mixed         $object   
     * @return void
     */
    protected function appendIfNotSatisfiedBy($specification, $object) {
        if (!$specification->isSatisfiedBy($object)) {
            if ($specification instanceof AbstractCombinationSpecification) 
                $this->notSatisfied = array_merge($this->notSatisfied, $specification->getSpecificationsNotSatisfiedBy($object));
            else 
                $this->notSatisfied[] = $specification;
        }
    }
}
