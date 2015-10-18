<?php

namespace Examples\Specifications;

use Examples\Person\Person;
use Arete\Specification\Specification;
use Arete\Specification\ParameterizedSpecification;
use Arete\Specification\SpecificationTrait;

class NameSpecification implements Specification, PersonsCharacteristics {
    use ParameterizedSpecification;
    use SpecificationTrait;

    protected $name; 

    public function __construct($name) {
        $this->name = $name;
    }        

    public function isSatisfiedBy(Person $person) {
        if ($this->name === $person->getName()) {
            return true;
        }
        return false;
    }

}