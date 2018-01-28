<?php 
function regularBracketSequence1($sequence)
{

    $balance = 0;
    for ($i = 0; $i < strlen($sequence); $i++)
    {
    if (substr($sequence, $i, 1) == '(')
    {
      $balance++;
    }
    else
    {
      $balance--;
    }
    if ($balance < 0)
    {
      return false;
    }
    }
    if ($balance != 0)
    {
    return false;
    }
    return true;
}

var_dump(regularBracketSequence1('()()'));
