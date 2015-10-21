<?php

namespace Arete\Specification;

class SpecificationFilterVisitor {
    /**
     * @var array<String> shorthand, or fully qualified class names to allow 
     */
    protected $whitelist;

    /**
     * @see $this->whitespace
     * @param array<String> $whitelist
     */
    public function __construct($whitelist) {
        $this->whitelist = $whitelist;
    }

    /**
     * gets both specification from a CombinationSpecification, runs them through match, combines them, uniques them
     * 
     * @param  AbstractCombinationSpecification $specification
     * @param  String                           $type        
     * @return array<Specification>             unique                                      
     */
    public function visit(AbstractCombinationSpecification $specification, $type) {
        $one = $this->match($specification->getSpecificationOne(), $type);
        $two = $this->match($specification->getSpecificationTwo(), $type);

        $specifications = array_merge($one, $two);
        return $specifications;
    }

    /**
     * @param  AbstractCombinationSpecification $specification
     * @param  String                           $type       
     * @return array<Specification>|array<>                                           
     */
    protected function match($specification, $type) {
        if ($matches = $this->matches($specification, $type)) {
            if (!is_array($matches))
                return [$matches];
            return $matches;
        }

        // no matches, empty array 
        return [];
    }

    /**
     * @param  AbstractCombinationSpecification $specification
     * @param  String                           $type       
     * @return array<Specification>|bool(false)                                      
     */
    public function matches($specification, $type) {
        $isNot = false;

        // if it is an array, currently that can only mean a nested `not`
        if (is_array($type)) {
            $type = current($type);
            $isNot = true;
            
            // even though it is looking for a nested not, it might not BE a nested not that we are checking
            if ($specification instanceof NotSpecification) 
                $specification = $specification->getSpecification();
        }

        // we want to do this after already checking if it was an array/not
        $type = ucfirst($type);
        
        // the Specification if it was just passed in as a shorthand
        $typeSpecificationSpecification = __NAMESPACE__ . '\\' . $type . 'Specification';
        
        // the Specification if it was just passed in as a non fully qualified classname, just missed ns 'Specification'
        $typeSpecification = __NAMESPACE__ . '\\' . $type;
        
        // if it matches either, it might have been passed in as shorthand OR custom
        if ($specification instanceof $type ||
            $specification instanceof $typeSpecification ||
            $specification instanceof $typeSpecificationSpecification) {
            
            if ($isNot) 
                return $specification->asNot();    

            return $specification;
        }

        return false;
    }
}