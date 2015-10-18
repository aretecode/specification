<?php

namespace Examples\Name;

use Examples\Person\Person;

class NameFactory {
    public static function createFrom($first, $second = "", $third = "") {
        // we know there can be no last name, as per rule 2.
        if ("" === $second) {
            return new Name($first, "", "");
        }
        
        // if second IS set and third is NOT, they provided first and last
        if ("" !== $second && "" === $third) {
            return new Name($first, $third);
        }

        // all we have left is all 3 
        // (someone could put "" in the second parameter
        // but that still is just an empty middle name which does not change)
        return new Name($first, $second, $third);
    }
}