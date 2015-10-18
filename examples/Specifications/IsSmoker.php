<?php

namespace Examples\Specifications;

use Examples\Person\Person;
use Arete\Specification\Specification;
use Arete\Specification\ParameterizedSpecification;
use Arete\Specification\SpecificationTrait;

class IsSmoker implements Specification, PersonsCharacteristics {
    use SpecificationTrait;
    public function isSatisfiedBy(Person $person) {
        if ($person->getIsSmoker()) {
            return true;
        }
        return false;
    }
}