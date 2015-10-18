<?php

namespace Examples;

use Arete\CollectionPipeline\CollectionPipeline as CP;

use Examples\Person\PersonRepository;
use Examples\Person\PersonFactory;
use Examples\Specifications\FirstNameIs;

require_once __DIR__.'/../vendor/autoload.php';

$personFactory = new PersonFactory();
$arrayOfPeople = array( 
    $personFactory->create(0, 'Tina',    '22-Sep-1945',  true),  #70
    $personFactory->create(1, 'Ricky',   '23-Dec-1955',  true),  #60
    $personFactory->create(2, 'Bobby',   '12-Oct-2010',  false), #5
    $personFactory->create(3, 'Mike',    '27-Nov-1940',  true),  #60
    $personFactory->create(4, 'Cal',     '15-Oct-1940',  false), #75
    $personFactory->create(5, 'Grendle', '29-Aug-1980',  false), #25
    $personFactory->create(6, 'Hilga',   '16-Jan-1973',  true),  #42
    $personFactory->create(7, 'Agatha',  '30-Jun-1970',  false), #45  
    $personFactory->create(8, 'Mortimer','11-Jul-1966',  true),  #49
);  

$peopleRepo = new PersonRepository($arrayOfPeople);
$peopleList = $peopleRepo->asArray();

$peopleMatching = 
    CP::from($peopleList)
    ->wheres('getIsSmoker', '===', true)
    ->wheres('getAge', '>=', 5)
    ->wheres('getAge', '<=', 70)
    
    /**
     * When we try `->wheres('getName', '==', 'Mortimer')`
     * and call getName == 'Mortimer' however, it needs to call
     * `getName()->getFirst()` which is currently not supported, 
     * so we mix and match with Specifications
     */
    ->satisfying(new FirstNameIs('Mortimer'))
    ->all();

var_dump($peopleMatching);