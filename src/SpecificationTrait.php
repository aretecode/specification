<?php

namespace Arete\Specification;

use InvalidArgumentException;
use DomainException;

trait SpecificationTrait {
	/**
	 * @throws InvalidArgumentException if `isSatisfiedBy` is not a method on the argument
	 * @param  Specification $specification 
	 * @return void
	 */
	protected function assertHasIsSatisfiedByMethod($specification) {
		if (!method_exists($specification, 'isSatisfiedBy'))
			throw new DomainException('Specification must have the method `isSatisfiedBy`');
	}

	/**
	 * @throws InvalidArgumentException if `isSatisfiedBy` is not a method on the argument
	 * @param  Specification $specification 
	 * @return AndSpecification
	 */
	public function andSatisfies($specification) {
		return new AndSpecification($this, $specification);
	}	

	/**
	 * @throws InvalidArgumentException if `isSatisfiedBy` is not a method on the argument
	 * @param  Specification $specification 
	 * @return AndSpecification
	 */
	public function orSatisfies($specification) {
		return new OrSpecification($this, $specification);
	}	

	/**
	 * @throws InvalidArgumentException if `isSatisfiedBy` is not a method on the argument
	 * @param  Specification $specification 
	 * @return NotSpecification
	 */
	public function notSatisfies($specification) {
		return new NotSpecification($this, $specification);
	}

	/**
	 * @throws InvalidArgumentException if `isSatisfiedBy` is not a method on the argument
	 * @param  Specification $specification 
	 * @return XorSpecification
	 */
	public function xorSatisfies($specification) {
		return new XorSpecification($this, $specification);
	}    

	/**
     * @return NotSpecification
     */
    public function asNot() {        
        return new NotSpecification($this);
    } 
}
