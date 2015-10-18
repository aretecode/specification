<?php

namespace Examples\Person;

use DateTime;

class Person {    
    protected $birthdate; 
    protected $smoker;      
    protected $name;  
    protected $id; 

    public function __construct($id, $name, $birthdate) {
        $this->id = $id;
        $this->birthdate = $birthdate;       
        $this->setName($name);
    }

    public function setSmoker($smoker) {
        $this->smoker = $smoker;    
    }  

    public function getIsSmoker() {
        return $this->smoker;
    }    

    public function setName($name) {
        $this->name = $name;    
    }    

    public function getName() {
        return $this->name;
    }   

    public function getId() {
        return $this->id;
    }  
    
    public function getBirthdate() {
        return $this->birthdate;
    }    

    public function getAge() {
        $date = new DateTime("now");
        $interval = $date->diff($this->birthdate);
        return $interval->format("%y");
    }
}