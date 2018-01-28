    <?php 
    /*
    For a string consisting of only '('s and ')'s, determine if it is a regular bracket sequence or not.

    Example

    For sequence = "()()", the output should be
    regularBracketSequence1(sequence) = true.

    We could insert (1 + 2) * (2 + 4) which is a valid arithmetic expression, so the answer is true.

    Input/Output

    [time limit] 3000ms (java)
    [input] string sequence

    Constraints:
    4 ≤ sequence.length ≤ 10.

    [output] boolean

    true if the bracket sequence is regular, false otherwise.
    */

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

        if ($balance <= 0)
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
