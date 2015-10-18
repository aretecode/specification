<?php

namespace Arete\Specification;

interface asQuery {

    /**
     * @example:
     *     - ['mysql' => '', 'dql' => ''] 
     *     
     * @var array<String#language, String#
     */
    protected $queries = [];
    
    /**
     * @param  String $language
     * @return String|null 
     */
    public function asQuery($language);
}
