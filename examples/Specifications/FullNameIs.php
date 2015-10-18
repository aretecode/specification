<?php

namespace Examples\Specifications;

use Examples\Person\Person;

class FullNameIs extends NameSpecification  
    public function isSatisfiedBy(Person $person) {
        if ($person->getName()->equals($this->name)) {
            return true;
        }
        return false;
    }
}