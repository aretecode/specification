<?php

namespace Examples\Specifications;

use Examples\Person\Person;
use Arete\Specification\Specification;
use Arete\Specification\ParameterizedSpecification;
use Arete\Specification\SpecificationTrait;

class OverOrSameAsAge implements Specification, PersonsCharacteristics {
    use ParameterizedSpecification;
    use SpecificationTrait;

    public function isSatisfiedBy(Person $person) {
        if ($person->getAge() >= $this->value) {
            return true;
        }
        return false;
    }
}