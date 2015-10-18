<?php

namespace Arete\Specification;

/**
 * Default Parameterized, used to make something matching "is_callable" into a Specification
 * 
 * @example 
 *     $closure = function($object) { 
 *         return is_object($object);
 *     };
 *
 *     new CallableSpecification($closure);
 */
class CallableSpecification extends AbstractSpecification implements Specification {
    use ParameterizedSpecification;
    use SatisfiedCallable;
}
