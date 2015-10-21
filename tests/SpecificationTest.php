<?php

namespace Arete\Specification;

use stdClass;

class SpecificationsTest extends \PHPUnit_Framework_TestCase {
    /** @var MockSpecification */
    protected $truemock;
    /** @var MockSpecification */
    protected $falsemock;
    /** @var MockSpecification */
    protected $falsezeromock;

    public function setUp() {
        $this->truemock = new MockSpecification(true);
        $this->falsemock = new MockSpecification(false);
        $this->falsezeromock = new MockSpecification(0);
    }

    public function testNotSpecification() {
        $not = new NotSpecification($this->truemock);
        $this->assertFalse($not->isSatisfiedBy(new stdClass));
        $not = new NotSpecification($this->falsemock);
        $this->assertTrue($not->isSatisfiedBy(new stdClass));
    }

    public function testAndSpecification() {
        $and = new AndSpecification($this->falsemock, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));
        $and = new AndSpecification($this->truemock, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));
        $and = new AndSpecification($this->falsemock, $this->truemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));
        $and = new AndSpecification($this->truemock, $this->truemock);
        $this->assertTrue($and->isSatisfiedBy(new stdClass));
    }

    public function testCompositeSpecification() {
        $composite = new CompositeSpecification($this->falsemock, $this->falsemock, $this->truemock);
        $this->assertFalse($composite->isSatisfiedBy(new stdClass));
        $composite = new CompositeSpecification($this->truemock, $this->truemock, $this->truemock);
        $this->assertTrue($composite->isSatisfiedBy(new stdClass));
    }

    public function testOrSpecification() {
        $and = new OrSpecification($this->falsemock, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));
        $and = new OrSpecification($this->truemock, $this->falsemock);
        $this->assertTrue($and->isSatisfiedBy(new stdClass));
        $and = new OrSpecification($this->falsemock, $this->truemock);
        $this->assertTrue($and->isSatisfiedBy(new stdClass));
        $and = new OrSpecification($this->truemock, $this->truemock);
        $this->assertTrue($and->isSatisfiedBy(new stdClass));
    }

    public function testFluentInterface() {
        $this->assertTrue(
            $this->truemock
                ->andSatisfies($this->truemock)
                ->isSatisfiedBy(new stdClass)
        );
        $this->assertFalse(
            $this->falsemock
                ->orSatisfies($this->falsemock)
                ->isSatisfiedBy(new stdClass)
        );
        $this->assertTrue(
            $this->falsemock->asNot()
                ->andSatisfies($this->falsemock->orSatisfies($this->truemock))
                ->andSatisfies($this->truemock)
                ->isSatisfiedBy(new stdClass)
        );
    }

    public function testGroupSpecification() {
        $group = new GroupSpecification($this->truemock);
        $this->assertTrue($group->isSatisfiedBy([new stdClass, new stdClass]));
    }

    public function testXorSpecification() {
        $xor = new XorSpecification($this->truemock, $this->truemock);
        $this->assertFalse($xor->isSatisfiedBy(new stdClass));
        $xor = new XorSpecification($this->truemock, $this->falsemock);
        $this->assertTrue($xor->isSatisfiedBy(new stdClass));
        $xor = new XorSpecification($this->falsemock, $this->truemock);
        $this->assertTrue($xor->isSatisfiedBy(new stdClass));
    }

    public function testGetSpecificationNotSatisfiedBy() {
        $and = new AndSpecification($this->truemock, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));

        $notSatisfiedBy = $and->getSpecificationsNotSatisfiedBy(new stdClass);
        $this->assertSame($this->falsemock, $notSatisfiedBy[0]);
    }

    public function testGetSpecificationsNotSatisfiedBy() {
        $andOne = new AndSpecification($this->truemock, $this->falsemock);
        $andTwo = new AndSpecification($andOne, $this->falsemock);
        $and = new AndSpecification($andTwo, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));

        $notSatisfiedBy = $and->getSpecificationsNotSatisfiedBy(new stdClass);
        $this->assertSame($this->falsemock, $notSatisfiedBy[0]);
    }

    public function testCombinationGetSpecificationsNotSatisfiedBy() {
        $andOne = new AndSpecification($this->truemock, $this->falsemock);
        $andTwo = new AndSpecification($andOne, $this->falsezeromock);
        $and = new AndSpecification($andTwo, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));

        $notSatisfiedBy = $and->getSpecificationsNotSatisfiedBy(new stdClass);

        $expected = [$this->falsemock, $this->falsezeromock, $this->falsemock];
        $this->assertSame($expected, $notSatisfiedBy);
    }
   
    public function testRemainderUnsatisfiedBy() {
        $andOne = new AndSpecification($this->truemock, $this->falsemock);
        $andTwo = new AndSpecification($andOne, $this->falsezeromock);
        $and = new AndSpecification($andTwo, $this->falsemock);
        $this->assertFalse($and->isSatisfiedBy(new stdClass));

        $notSatisfiedBy = $and->remainderUnsatisfiedBy(new stdClass);
        $specificationsNotSatisfiedBy = $notSatisfiedBy->getSpecificationsNotSatisfiedBy(new stdClass);
        $expected = [$this->falsemock, $this->falsezeromock, $this->falsemock];
        $this->assertSame($expected, $specificationsNotSatisfiedBy);
    }
    
    public function testCallableSpecificationTest() {
        $callable = function($object) {
            return true;
        };
        $this->assertTrue(is_callable($callable));

        $general = new CallableSpecification($callable);
        $this->assertTrue($general->isSatisfiedBy(new stdClass));
    }

    public function testisGeneralizationOf() {
        return true;
    }

    public function testAsXor() {
        $or = new OrSpecification($this->truemock, $this->falsemock);
        $xor = $or->asXor();
        
        $xorDefined = new XorSpecification($this->truemock, $this->falsemock);
        $this->assertTrue($xor instanceof XorSpecification);
        $this->assertEquals($xor, $xorDefined);
    }
    public function testAsOr() {
        $and = new AndSpecification($this->truemock, $this->truemock);
        $or = $and->asOr();
        
        $orDefined = new OrSpecification($this->truemock, $this->truemock);
        $this->assertTrue($or instanceof OrSpecification);
        $this->assertEquals($or, $orDefined);
    }
    public function testAsAnd() {
        $or = new OrSpecification($this->truemock, $this->truemock);
        $and = $or->asAnd();
        
        $andDefined = new AndSpecification($this->truemock, $this->truemock);
        
        $this->assertTrue($and instanceof AndSpecification);
        $this->assertTrue($and->isSatisfiedBy(new stdClass));
        $this->assertEquals($and, $andDefined);
    }

    public function testGetSpecificationsMatching() {
        $and = new AndSpecification($this->truemock, $this->falsemock);
        $matching = $and->getSpecificationsMatching();
        $expected = [$this->falsemock, $this->truemock];

        $this->orderByValueAndAssignNewKeys($matching);
        $this->orderByValueAndAssignNewKeys($expected);
        $this->assertEquals($expected, $matching, 'two matching specification arrays equaling');
    }

    public function testGetSpecificationsMatchingUnique() {
        $and = new AndSpecification($this->truemock, $this->truemock);
        $matching = $and->getSpecificationsMatching();
        $this->assertEquals($matching, [$this->truemock], 'two unique specification arrays equaling');
    }

    public function testGetSpecificationsMatchingNested() {
        $not = $this->falsemock->asNot();
        $or = new OrSpecification($this->truemock, $this->falsezeromock);
        $and = new AndSpecification($or, $not);

        $matching = $and->getSpecificationsMatching();
        $expected = [$or, $not];
        $this->orderByValueAndAssignNewKeys($matching);
        $this->orderByValueAndAssignNewKeys($expected);

        $this->assertEquals($expected, $matching, 'two matching nested specification arrays');
    }

    public function testGetSpecificationsMatchingNestedPattern() {
        $not = $this->falsemock->asNot();
        $or = new OrSpecification($this->truemock, $this->falsemock);
        $and = new AndSpecification($or, $not);
        $matching = $and->getSpecificationsMatching([['not' => 'MockSpecification']]);
        $expected = [$not];

        $this->orderByValueAndAssignNewKeys($matching);
        $this->orderByValueAndAssignNewKeys($expected);

        $this->assertEquals($expected, $matching, 'two pattern matching nested arrays equaling');
    }

    public function testGetMultipleSpecificationsMatchingNestedPatternNotGettingChildren() {
        $not = $this->falsemock->asNot();
        $callableSpecification = new CallableSpecification(function(){return true;});
        $or = new OrSpecification($this->truemock, $this->falsemock);
        $andOne = new AndSpecification($or, $not);
        $and = new AndSpecification($andOne, $callableSpecification);

        $matching = $and->getSpecificationsMatching(['and', 'callable', ['not' => 'MockSpecification']]);
        $expected = [$andOne, $callableSpecification];
        $this->orderByValueAndAssignNewKeys($matching);
        $this->orderByValueAndAssignNewKeys($expected);

        $this->assertEquals($expected, $matching, 'two pattern matching nested arrays equaling without children');
    }
    public function testGetMultipleSpecificationsMatchingPattern() {
        $not = $this->falsemock->asNot();
        $callableSpecification = new CallableSpecification(function(){return true;});
        $and = new AndSpecification($not, $callableSpecification);
       
        $matching = $and->getSpecificationsMatching([['not' => 'MockSpecification'], 'callable', CallableSpecification::CLASS]);
        $expected = [$callableSpecification, $not];

        $expected = $this->orderByValueAndAssignNewKeys($expected);
        $matching = $this->orderByValueAndAssignNewKeys($matching);
       
        $this->assertEquals($expected, $matching, 'two multiple pattern matching nested arrays equaling');
    } 

    public function orderByValueAndAssignNewKeys(&$array) {
        sort($array);
        
        usort($array, function($a, $b) {
            $la = strlen(get_class($a));
            $lb = strlen(get_class($b));

            if ($la == $lb)
                return 0;

            return ($la < $lb) ? -1 : +1;
        });

       
        return $array;
    }
}
