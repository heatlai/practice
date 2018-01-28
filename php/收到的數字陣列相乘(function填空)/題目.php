<?php
/*
Given an array of integers, find the product of its elements.

Example

For inputArray = [1, 3, 2, 10], the output should be
arrayElementsProduct(inputArray) = 60.

Input/Output

[time limit] 3000ms (java)
[input] array.integer inputArray

Non-empty array of integers.

Constraints:
2 ≤ inputArray.length ≤ 10,
-15 ≤ inputArray[i] ≤ 15.

[output] integer

Product of all elements of inputArray.
*/

function arrayElementsProduct($inputArray)
{

  $result =  ... ;

  for ($i = 1; $i < count($inputArray); $i++)
  {
    $result *= $inputArray[$i];
  }
  
  return $result;
}