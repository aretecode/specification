<?php

namespace Examples\Specifications;

use Examples\Person\Person;

class LastNameIs extends NameSpecification {
    public function isSatisfiedBy(Person $person) {
        if ($this->name == $person->getName()->getLast()) {
            return true;
        }
        return false;
    }
}