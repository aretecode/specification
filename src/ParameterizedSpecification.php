<?php

namespace Arete\Specification;

trait ParameterizedSpecification {
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value) {
        $this->value = $value;
    }
}
