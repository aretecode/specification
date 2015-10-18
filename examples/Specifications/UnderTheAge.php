<?php

namespace Examples\Specifications;

use Examples\Person\Person;
use Arete\Specification\Specification;
use Arete\Specification\DefaultSpecification;

class UnderTheAge implements Specification, PersonsCharacteristics {
    use DefaultSpecification;
    public function isSatisfiedBy(Person $person) {
        if ($this->value > $person->getAge()) {
            return true;
        }
        return false;
    }
}