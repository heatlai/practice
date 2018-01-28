<?php

$aData = getCSVdata('A.csv');
pre_print_r($aData);

/**把資料重組成 KEY => value
 * [0]name
 * [1]York
 * [2]Heat
 * 變成 [0]['name'] => york
 *      [1]['name'] => Heat
 */
function getCSVdata($filename)
{
    $row = 1;//第一行開始
    if(($handle = fopen($filename, "r")) !== false)
    {
        while(($dataRow = fgetcsv($handle)) !== false)
        {
            $num = count($dataRow);

            for ($c = 0; $c < $num; $c++)//列 column
            {
                if($row === 1)//第一行作為 column name
                {
                    $colName[] = $dataRow[$c];
                }
                else
                {
                    foreach ($colName as $k => $v)
                    {
                        if($k == $c) //對應的字段
                        {
                            $data[$v] = $dataRow[$c];
                        }
                    }
                }
            }

            if(!empty($data))
            {
                $dataResult[] = $data;
                unset($data);
            }
            $row++;
        }
        fclose($handle);
        return $dataResult;
    }
}

function pre_print_r($input)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}