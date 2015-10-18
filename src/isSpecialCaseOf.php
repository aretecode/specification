<?php

namespace Arete\Specification;

/**
 * This extension allows two specifications to be compared to one another. 
 * 
 * Specification B is a special case of Specification A 
 * if and only if for any possible candidate object X, 
 * where A is satisfied by X, 
 * B will always be satisfied by X also. 
 * 
 * If this is true, 
 * it is possible to apply any conclusion reached using B to A, 
 * hence B can subsume A. 
 * 
 */
interface isSpecialCaseOf {
    /**
     * @param  Specification $specification
     * @return boolean
     */
    public function isSpecialCaseOf($specification);
}
