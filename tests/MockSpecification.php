<?php

namespace Arete\Specification;

class MockSpecification implements Specification {
    use SpecificationTrait;

    protected $result;

    public function __construct($result) {
        $this->result = $result;
    }
    public function isSatisfiedBy($object) {
        return (bool) $this->result;
    }
}