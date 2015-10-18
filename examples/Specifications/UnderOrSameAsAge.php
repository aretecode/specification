<?php

namespace Examples\Specifications;

use Examples\Person\Person;
use Arete\Specification\Specification;
use Arete\Specification\ParameterizedSpecification;
use Arete\Specification\SpecificationTrait;

class UnderOrSameAsAge implements Specification, PersonsCharacteristics {
    use ParameterizedSpecification;
    use SpecificationTrait;
    public function isSatisfiedBy(Person $person) {
        if ($this->value >= $person->getAge()) {
            return true;
        }
        return false;
    }
}