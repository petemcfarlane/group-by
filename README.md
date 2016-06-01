[![Build Status](https://travis-ci.org/petemcfarlane/group-by.svg?branch=master)](https://travis-ci.org/petemcfarlane/group-by)
[![Latest Stable Version](https://poser.pugx.org/group-by/group-by/v/stable)](https://packagist.org/packages/group-by/group-by)
[![License](https://poser.pugx.org/group-by/group-by/license)](https://packagist.org/packages/group-by/group-by)

# groupBy

Adds grouping functionality to arrays. Arrays can be grouped by array key or by a callback.

## Example 1: Group by array key

```php
<?php

use function GroupBy\groupBy;

$students = [
    ['name' => 'adam', 'year' => '10'],
    ['name' => 'becky', 'year' => '12'],
    ['name' => 'chris', 'year' => '11'],
    ['name' => 'deborah', 'year' => '10'],
    ['name' => 'edward', 'year' => '12'],
];

$groupedByYear = groupBy($students, 'year');

/*
$groupedByYear is equal to
[
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
]
*/
```

## Example 2: Group by callback

```php
<?php

use function GroupBy\groupBy;

$numberList = [1, 2, 3, 4, 5, 987, 554, 32];

// The array item value will be passed to the callback.
$oddOrEven = function ($n) {
    return $n % 2 == 0 ? 'even' : 'odd';
};

$oddAndEven = groupBy($numberList, $oddOrEven);

/*
$oddAndEven is now equal to
[
    'odd' => [1, 3, 5, 987],
    'even' => [2, 4, 554, 32],
];
*/
```

## Example 3: Group by callback on an array of objects

Much like the above example, the input array can be an array of objects.

```php
<?php

use function GroupBy\groupBy;

// $students in an array of `stdClass Object`
$students = [
    (object) ['name' => 'adam', 'year' => '10'],
    (object) ['name' => 'becky', 'year' => '12'],
    (object) ['name' => 'chris', 'year' => '11'],
    (object) ['name' => 'deborah', 'year' => '10'],
    (object) ['name' => 'edward', 'year' => '12'],
];

$groupByYear = function ($student) {
    return $student->year;
};

$groupedByYear = groupBy($students, $groupByYear);

/*
$groupedByYear is now equal to
[
    [10] => [
        [0] => stdClass Object
            (
                [name] => adam
                [year] => 10
            )
        [1] => stdClass Object
            (
                [name] => deborah
                [year] => 10
            )
        ]
    [12] => [
        [0] => stdClass Object
            (
                [name] => becky
                [year] => 12
            )
        [1] => stdClass Object
            (
                [name] => edward
                [year] => 12
            )
        ]
    [11] => [
        [0] => stdClass Object
            (
                [name] => chris
                [year] => 11
            )
    ]
]
*/
```