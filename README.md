# Arete\Specification
[![Build Status](https://secure.travis-ci.org/aretecode/specification.svg)](https://travis-ci.org/aretecode/specification)
[![HHVM Status](http://hhvm.h4cc.de/badge/arete/specification.svg)](http://hhvm.h4cc.de/package/arete/specification)
[![Author](http://img.shields.io/badge/author-@aretecode-blue.svg)](https://twitter.com/aretecode)
[![Latest Unstable Version](https://poser.pugx.org/arete/specification/v/unstable)](https://packagist.org/packages/arete/specification)
[![License](https://poser.pugx.org/arete/specification/license)](http://packagist.org/packages/arete/specification)

Specification library in PHP.

[Eric Evans & Martin Fowlers paper on Specifications](http://martinfowler.com/apsupp/spec.pdf)

# [Example](https://github.com/aretecode/specification/blob/master/examples)
[See my post on refactoring]()

A post detailing the usage in more detail will be available soon.

## Installation
It can be installed from [Packagist](https://packagist.org/arete/specification) using [Composer](https://getcomposer.org/). 

In your project root just run:

`$ composer require arete/specification`

Make sure that you’ve set up your project to [autoload Composer-installed packages](https://getcomposer.org/doc/00-intro.md#autoloading).


## Running tests
Run via the command line by going to `arete/specification` directory and running `phpunit`


## @TODO
* [ ] ::getAllSpecifications()
* [ ] ::getAllNotSpecifications()
* [ ] ::getAllAndSpecifications()
* [ ] ::getAllXorSpecifications()
* [ ] ::getAllOrSpecifications()
* [ ] ::getAll__Specifications($not = false) // if $not then search for ones with not
* [x] ::remainderUnsatisfiedBy()
* [ ] ::isGeneralizationOf()
* [ ] ::isSpecializationOf()
* [ ] ::asQuery() for use with db, whether it uses argument, or sep methods
* [ ] abstract part of the Collection Pipeline matching into default/premades

### P.S.
(I have had this written since I read the DDD books, I updated it a little and just found an old one by [@mathiasverraes](https://github.com/mathiasverraes/DomainTools) which was interesting!)