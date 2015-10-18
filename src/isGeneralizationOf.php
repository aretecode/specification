<?php

namespace Arete\Specification;

/**
 * Subsumption
 */  
interface isGeneralizationOf {
    /**
     * @param  Specification $specification 
     * @return boolean 
     */
    public function isGeneralizationOf($object);
}
