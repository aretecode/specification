<?php

namespace Examples\Specifications;

use Examples\Person\Person;

class FirstNameIs extends NameSpecification {
    public function isSatisfiedBy(Person $person) {
        if ($this->name == $person->getName()->getFirst()) {
            return true;
        }
        return false;
    }
}