<?php
function arrayElementsProduct($inputArray)
{

  $result =  $inputArray[0] ;

  for ($i = 1; $i < count($inputArray); $i++)
  {
    $result *= $inputArray[$i];
  }
  
  return $result;
}

$array = array(1, 3, 2, 10);
echo arrayElementsProduct($array);