<?php

namespace Examples\Person;

use Arete\Specification\Specification;

class PersonRepository {
    /** @array<Person> */
    protected $people;

    public function __construct(array $people) {
        $this->people = $people;
    }
    
    /** return array<Person> */
    public function asArray() {
        return $this->people;
    }
    
    /** array<Person|null> */
    public function findSmokers($specification) {
        $isSmoker = new IsSmoker();
        return $this->findSatisfying($isSmoker);
    }    

    /** @return array<Person|null> */
    public function findSatisfying(Specification $specification) {
        $peopleMatching = [];
        foreach ($this->people as $person) {
            if ($specification->isSatisfiedBy($person)) {
                $peopleMatching[] = $person;
            }
        }
        return $peopleMatching;
    }
}