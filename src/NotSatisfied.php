<?php

namespace Arete\Specification;

trait NotSatisfied {
    /**
     * adds it to $this->notSatisfied if it does not match
     * 
     * @param  Specification $specification 
     * @param  mixed         $object   
     * @param  array         &[$notSatisfied] (optional) array to contain the not satisfiedBy @array<Specification)
     * @return void
     */
    protected function appendIfNotSatisfiedBy($specification, $object, array &$notSatisfied = []) {
        if (!$specification->isSatisfiedBy($object)) {
            if ($specification instanceof AbstractCombinationSpecification) 
                $notSatisfied = array_merge($notSatisfied, $specification->getSpecificationsNotSatisfiedBy($object));
            else 
                $notSatisfied[] = $specification;
        }
    }
}
