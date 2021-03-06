<?php

namespace Examples;

use Arete\Specification\AndSpecification;
use Examples\Person\PersonRepository;
use Examples\Person\PersonFactory;

use Examples\Specifications\OverOrSameAsAge;
use Examples\Specifications\UnderOrSameAsAge;
use Examples\Specifications\FirstNameIs;
use Examples\Specifications\IsSmoker;

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

$fivePlus = new OverOrSameAsAge(5);
$namedMortimer = new FirstNameIs('Mortimer');

$overFive_and_NamedMortimer = new AndSpecification($fivePlus, $namedMortimer);

// can use ::asAnd, ::asXor, ::asOr
$overFive_or_NamedMortimer = $overFive_and_NamedMortimer->asOr();

$peopleMatching = $peopleRepo->findSatisfying($overFive_or_NamedMortimer);

var_dump($peopleMatching);