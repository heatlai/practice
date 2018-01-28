<?php

//檢查多維陣列內數值是否存在
function deep_in_array($value, $input_array)
{
    foreach ($input_array as $in_value)
    {
        if(!is_array($in_value))
        {
            if ($value == $in_value)
            {
                return TRUE;
            }
        }
        else
        {
            if(deep_in_array($value, $in_value))
            {
                return TRUE;
            }
        }
    }

    return FALSE;
}