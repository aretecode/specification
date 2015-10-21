<?php

namespace Arete\Specification;

class CompositeSpecification extends AbstractSpecification implements Specification {
    use NotSatisfied;

    /** @var array<Specification> */
    protected $specifications = array();

    /**
     * @param Specification $specifications
     *      variable length argument, also support array
     */
    public function __construct(...$specifications) {
        foreach ($specifications as $specification) {
            // if it an array, merge it, then skip/continue to the next
            if (is_array($specification)) {
                $this->specifications = array_merge($this->specifications, $specification);  
                continue;      
            } 

            $this->specifications[] = $specification;        
        }
    }

    /**
     * add another Specification
     *
     * @param Specification $specification
     */
    public function addSpecification(Specification $specification) {
        $this->specifications[] = $specification;
    }

    /**
     * checks each of the Specifications in $this->specifications
     * 
     * @param  mixed $object 
     * @return bool       
     */
    public function isSatisfiedBy($object) {
        foreach ($this->specifications as $specification)
            if (!$specification->isSatisfiedBy($object)) 
                return false;
        return true;
    }

    /**
     * Specifications that are NOT satisfied, 
     * 
     * @param $object 
     * @return array<Specification> 
     *          that are not satisfied by the argument
     */
    public function getSpecificationsNotSatisfiedBy($object) {
        $notSatisfied = [];

        foreach ($this->specifications as $specification)
            $this->appendIfNotSatisfiedBy($specification, $object, $notSatisfied);

        return $notSatisfied;
    }
}