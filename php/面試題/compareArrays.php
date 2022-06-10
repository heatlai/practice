<?php

/**
 * Write a function to compare 2 arrays that contain integers.
 * Return true if they have the same elements, otherwise return false.
 * There can be 1 million elements in each array.
 * Elements in the array might be duplicate.
 *
 * Note that the elements in the arrays could be in different orders.
 * e.g.:
 * [1, 2, 3, 3] is considered the same as [3, 1, 2, 3]
 * [0, 0, 1] is considered NOT the same as [0, 1]
 *
 * Use whatever language you're the most comfortable with.
 * Write down the assumptions you make.
 * Explain the time complexity and performance of your solution
 */

/**
 * @param int[] $arr1
 * @param int[] $arr2
 * @return bool
 */
function compareArrays($arr1, $arr2) {
    // different length
    if( count($arr1) !== count($arr2) ) {
        return false;
    }

    /**
     * sort(): Quick Sort + Insertion Sort
     *
     * Document
     * @link https://www.php.net/sort
     *
     * Source code
     * @link https://github.com/php/php-src/blob/master/Zend/zend_sort.c#L248
     *
     * Time Complexity
     * Worst: O(n^2)
     * Best: O(n log n)
     * Average: O(n log n)
     * Space: O(n)
     */
    sort($arr1, SORT_NUMERIC);
    sort($arr2, SORT_NUMERIC);
    return $arr1 === $arr2;
}

// test case
assert(compareArrays([1, 2, 3, 3], [3, 1, 2, 3]));
assert(!compareArrays([0, 0, 1], [0, 1]));

// demo
ini_set("memory_limit", '256M');
$arr1 = newIntArray(1000000);
$arr2 = newIntArray(1000000);
$startTime = microtime(true);
$result = compareArrays($arr1, $arr2);
$endTime = microtime(true);
echo 'compareArrays(): ' . ($result ? 'true' : 'false') . PHP_EOL;
echo 'Execution time: ' . number_format(($endTime - $startTime) * 1000, 2) . ' ms' . PHP_EOL;
echo 'Memory limit: ' . ini_get("memory_limit") . PHP_EOL;
echo 'Memory usage: ' . number_format(round(memory_get_usage() / 1024)) . ' KB' . PHP_EOL;
echo 'Memory peak usage: ' . number_format(round(memory_get_peak_usage() / 1024)) . ' KB' . PHP_EOL;

function newIntArray($amount) {
    $arr = [];
    for ($i = 0; $i < $amount; $i++) {
        $arr[] = rand(0, 100);
    }
    return $arr;
}
