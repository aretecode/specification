<?php

namespace Examples\Person;

use DateTime;
use Examples\Name\NameFactory;
use Examples\Name\Name;

class PersonFactory {
    public function create($id, $firstName, $birthDateString, $isSmoker) {
        $person = new Person(
            $id, 
            NameFactory::createFrom($firstName), 
            DateTime::createFromFormat('j-M-Y', $birthDateString));
        $person->setSmoker($isSmoker);
        return $person;
    }
}
