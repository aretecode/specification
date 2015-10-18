<?php

namespace Arete\Specification;

interface remainderUnsatisfiedBy {
    /**
     * @param  Specification $specification
     * @return boolean
     */
    public function remainderUnsatisfiedBy($object);
}