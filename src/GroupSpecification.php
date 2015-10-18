<?php

namespace Arete\Specification;

/**
 * Premade for arrays of things to be satisfied, could be in example or another module?
 */
class GroupSpecification extends AbstractSpecification implements Specification {
    protected $specification;

    /**
     * @param spec Specification (probably a AndOrSpecification)
     */
    public function __construct($specification) {
        $this->specification = $specification;
    }

    /**
     * 
     * $specification = method_exists($this->specification, 'asOr') ? $this->specification->asOr() : $specification;
     *
     * @param  array
     * @return bool
     */
    public function isSatisfiedBy($group) {
        $satisfied = array();
        foreach ($group as $key => $object) 
            if ($this->specification->isSatisfiedBy($object)) 
                $satisfied[$key] = true; 

        // if there as many things in $satisfied[] as $group[]
        return (count($group) == count($satisfied)) ? true : false;
    }
}
