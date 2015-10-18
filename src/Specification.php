<?php

namespace Arete\Specification;

/**
 * Check if {@code t} is satisfied by the specification.
 *
 * @param t Object to test.
 * @return {@code true} if {@code t} satisfies the specification.
 *
 * I want to use this, but cannot use Generics and the parameters may be more than 1
 * public function isSatisfiedBy($object);
 */  
interface Specification
{
	/**
	 * Create a new specification that is the AND operation of {@code this} specification and another specification.
	 * @param specification Specification to AND.
	 * @return A new specification.
	 */
	public function andSatisfies($object);
	
	/**
	 * Create a new specification that is the OR operation of {@code this} specification and another specification.
	 * @param specification Specification to OR.
	 * @return A new specification.
	 */
	public function orSatisfies($object);
    
    /**
     * Create a new specification that is the NOT operation of {@code this} specification.
     * @param specification Specification to NOT.
     * @return A new specification.
     */
    public function notSatisfies($object);
   
    /**
     * @throws InvalidArgumentException if `isSatisfiedBy` is not a method on the argument
     * @param  Specification $specification 
     * @return XorSpecification
     */
    public function xorSatisfies($specification);

    /**
     * @return NotSpecification
     */
    public function asNot();
}
