<?php

use function PeteMc\GroupBy\groupBy;

class GroupByTest extends PHPUnit_Framework_TestCase
{
    public function testCanGroupByStringKey()
    {
        $input = [
            ['name' => 'adam', 'year' => '10'],
            ['name' => 'becky', 'year' => '12'],
            ['name' => 'chris', 'year' => '11'],
            ['name' => 'deborah', 'year' => '10'],
            ['name' => 'edward', 'year' => '12'],
        ];

        $expected = [
            10 => [
                ['name' => 'adam', 'year' => '10'],
                ['name' => 'deborah', 'year' => '10'],
            ],
            11 => [
                ['name' => 'chris', 'year' => '11'],
            ],
            12 => [
                ['name' => 'becky', 'year' => '12'],
                ['name' => 'edward', 'year' => '12'],
            ],
        ];

        assertEquals($expected, groupBy($input, 'year'));
    }

    public function testCanGroupByCallback()
    {
        $input = [1, 2, 3, 4, 5, 987, 554, 32];

        $oddOrEven = function ($n) {
            return $n % 2 == 0 ? 'even' : 'odd';
        };

        $expected = [
            'odd' => [1, 3, 5, 987],
            'even' => [2, 4, 554, 32],
        ];

        assertEquals($expected, groupBy($input, $oddOrEven));
    }

    public function testGroupByCallbackOnObjects()
    {
        $input = [
            (object) ['name' => 'adam', 'year' => '10'],
            (object) ['name' => 'becky', 'year' => '12'],
            (object) ['name' => 'chris', 'year' => '11'],
            (object) ['name' => 'deborah', 'year' => '10'],
            (object) ['name' => 'edward', 'year' => '12'],
        ];

        $expected = [
            10 => [
                (object) ['name' => 'adam', 'year' => '10'],
                (object) ['name' => 'deborah', 'year' => '10'],
            ],
            11 => [
                (object) ['name' => 'chris', 'year' => '11'],
            ],
            12 => [
                (object) ['name' => 'becky', 'year' => '12'],
                (object) ['name' => 'edward', 'year' => '12'],
            ],
        ];

        $groupByYear = function ($person) {
            return $person->year;
        };

        assertEquals($expected, groupBy($input, $groupByYear));
    }

    public function testGroupingEmptyArray()
    {
        assertEquals([], groupBy([], 'arbitary_key'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testKeyMustBeCallableOrString()
    {
        $input = [];
        groupBy($input, 7);
    }

    public function testCanOnlyBeCalledOnAnArray()
    {
        // if using PHP7
        if (class_exists(\TypeError::class)) {
            $this->expectException(\TypeError::class);
            groupBy("a string", "foo");
        }
    }
}
