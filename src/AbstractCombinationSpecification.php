<?php

namespace Arete\Specification;

use Arete\Specification\CompositeSpecification;
use Arete\Specification\AndSpecification;
use Arete\Specification\OrSpecification;
use Arete\Specification\XorSpecification;

abstract class AbstractCombinationSpecification extends AbstractSpecification implements Specification {
    use NotSatisfied;

    /**
     * @var Specification
     */
    protected $specificationOne;

    /**
     * @var Specification
     */
    protected $specificationTwo;

    /**
     * @param Specification $specificationOne
     * @param Specification $specificationTwo
     */
    public function __construct($specificationOne, $specificationTwo) {
        $this->specificationOne = $specificationOne;
        $this->specificationTwo = $specificationTwo;
    }

    /**
     * @return Specification $specificationOne
     */
    public function getSpecificationOne() {
        return $this->specificationOne;
    }

    /**
     * @return Specification $specificationTwo
     */
    public function getSpecificationTwo() {
        return $this->specificationTwo;
    }

    /**
     * @throws DomainException if either of the specifications are not set
     * @param  Specification $specification
     * @return void
     */
    public function assertBothSpecificationsAreSet() {
        if (!isset($this->specificationOne) || !isset($this->specificationTwo))
            throw new InvalidArgumentException('Specifications must both be set to convert');
    }

    /**
     * if it has the $as in a method, use that, if not, return the argument
     * Example:
     *     - 'Or' becomes 'asOr()'
     *     - 'And' becomes 'asAnd()'
     *
     * @param  Specification $specification
     * @param  string        $as
     * @return void
     */
    public function getSpecificationAs($specification, $as) {
        if (method_exists($specification, 'as' . $as))
            $specification = $specification->asOr();
        return $specification;
    }

    /**
     * @see ::getSpecificationAs
     *
     * Example:
     *     - 'or' becomes 'Or',
     *       checks if it can get the specification One & Two `asOr`,
     *       adds them both to an OrSpecification which is returned
     *
     *     - 'and' becomes 'And',
     *       checks if it can get the specification One & Two `asAnd`,
     *       adds them both to an AndSpecification which is returned
     *
     * @param  Specification $specification
     * @param  string        $as
     * @return void
     */
    public function asCombinationType($as) {
        $as = ucfirst($as);
        $specificationOne = $this->getSpecificationAs($this->specificationOne, 'as' . $as);
        $specificationTwo = $this->getSpecificationAs($this->specificationTwo, 'as' . $as);

        $class = $as . 'Specification';
        $fqcn = __NAMESPACE__ . '\\' . $class;
        return new $fqcn($specificationOne, $specificationTwo);
    }

    /**
     * @return OrSpecification
     */
    public function asOr() {
        return $this->asCombinationType('Or');
    }

    /**
     * @return AndSpecification
     */
    public function asAnd() {
        return $this->asCombinationType('And');
    }

    /**
     * @return XorSpecification
     */
    public function asXor() {
        return $this->asCombinationType('Xor');
    }

    /**
     * @see $this->specificationOne
     * @see $this->specificationTwo
     * 
     * @return array<Specification>
     */
    public function getAllSpecifications() {
        return [$this->specificationOne, $this->specificationTwo];
    }

    /**
     * @example  
     *      $types = [['not' => ['xor']], 'xor', 'and', 'or', 'composite', 'callable', 'customtype']
     *
     * @return array<Specification> that are satisfied by the argument
     */
    public function getSpecificationsMatching($whitelist = ['not', 'xor', 'and', 'or', 'composite', 'specification']) {
        $specifications = [];
        $visitor = new SpecificationFilterVisitor($whitelist);

        // could change this to check if the value exists first
        foreach ($whitelist as $type) 
            $specifications = array_merge($specifications, $visitor->visit($this, $type));
        
        $specifications = array_unique($specifications, SORT_REGULAR);

        return $specifications;
    }

    /**
     * @param $object here or set as property in Specifications...
     *
     * @return array<Specification> that are not satisfied by the argument
     */
    public function getSpecificationsNotSatisfiedBy($object) {
        $notSatisfied = [];
        $this->appendIfNotSatisfiedBy($this->specificationOne, $object, $notSatisfied);
        $this->appendIfNotSatisfiedBy($this->specificationTwo, $object, $notSatisfied);

        return $notSatisfied;
    }

    /**
     * @return CompositeSpecification
     */
    public function remainderUnsatisfiedBy($object) {
        return new CompositeSpecification($this->getSpecificationsNotSatisfiedBy($object));
    }
}
