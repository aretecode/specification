<?php

namespace Examples\Specifications;

use Examples\Person\Person;

interface PersonsCharacteristics {
    public function isSatisfiedBy(Person $person);
}