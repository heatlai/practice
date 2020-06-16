<?php



$a = json_decode('{"salaryIncreaseType":"percent","salaryTotalIncreasePercent":"5","salaryTotalIncreaseAmount":"0","newSalaryStartDate":"20\/06\/2020","data":[{"EmployeeId":"35401","BaseSalary":"90,000.00","Salary":{"Increase":"10.00","newSalaryStartDate":"20\/06\/2020"},"Bonus":{"Increase":"2000"}}],"bonusIncreaseType":"amount","bonusTotalIncreasePercent":"","bonusTotalIncreaseAmount":"1000","bonusPaymentDate":"20\/06\/2020","name":"Nathan04","jobs":"","department":"","location":"","selectColumn":["annualLeave","bonus","salaryIncrease","performanceScore","otherCost"]}',
    true);

$b = json_decode('{"salaryIncreaseType":"percent","salaryTotalIncreasePercent":"5","salaryTotalIncreaseAmount":"0","newSalaryStartDate":"20\/06\/2020","data":[{"EmployeeId":"35402","BaseSalary":"90,000.00","Salary":{"Increase":"15.00","newSalaryStartDate":"20\/06\/2020"},"Bonus":{"Increase":"3000"}}],"bonusIncreaseType":"amount","bonusTotalIncreasePercent":"","bonusTotalIncreaseAmount":"1000","bonusPaymentDate":"25\/06\/2020","name":"Nathan05","jobs":"","department":"","location":"","selectColumn":["annualLeave","bonus","salaryIncrease"]}',
    true);

/**
 * 遞迴 array diff，保留 arrayA 的差異內容
 * @param $arrayA
 * @param $arrayB
 * @return array
 */
function array_diff_recursive(array $arrayA, array $arrayB)
{
    $res = array();
    foreach ($arrayA as $aKey => $aValue) {
        // array1 的 key 在 array2 也有，進入比對
        if (array_key_exists($aKey, $arrayB)) {
            // value 也是 array 時遞迴比對
            if (is_array($aValue)) {
                $diff = array_diff_recursive($aValue, $arrayB[$aKey]);
                // 有差異就塞進 res
                if (count($diff)) {
                    $res[$aKey] = $diff;
                }
                // 不是 array 時進行全等比對
            } elseif ($aValue !== $arrayB[$aKey]) {
                $res[$aKey] = $aValue;
            }
            // array2 key 不存在就直接進 res
        } else {
            $res[$aKey] = $aValue;
        }
    }
    return $res;
}

/**
 * 比對陣列修改前修改後
 * key 不存在的話 value 會是 null
 * 所以正常的 value 不能有 null，只能有 empty string("")
 * @param $before
 * @param $after
 * @return array
 */
function config_diff(array $before, array $after)
{
    $arrayDiffRecursive = static function ($firstArray, $secondArray, $reverseKey = false) use (&$arrayDiffRecursive) {
        $oldKey = $reverseKey ? 'new' : 'old';
        $newKey = $reverseKey ? 'old' : 'new';
        $difference = [];
        foreach ($firstArray as $firstKey => $firstValue) {
            if (is_array($firstValue)) {
                if ( ! array_key_exists($firstKey, $secondArray) || ! is_array($secondArray[$firstKey]) ) {
                    $difference[$oldKey][$firstKey] = $firstValue;
                    $difference[$newKey][$firstKey] = $secondArray[$firstKey] ?? null;
                } else {
                    $deepDiff = $arrayDiffRecursive($firstValue, $secondArray[$firstKey], $reverseKey);
                    if ( ! empty($deepDiff)) {
                        $difference[$oldKey][$firstKey] = $deepDiff[$oldKey];
                        $difference[$newKey][$firstKey] = $deepDiff[$newKey];
                    }
                }
            } elseif ( ! array_key_exists($firstKey, $secondArray) || $secondArray[$firstKey] !== $firstValue) {
                $difference[$oldKey][$firstKey] = $firstValue;
                $difference[$newKey][$firstKey] = $secondArray[$firstKey] ?? null;
            }
        }
        return $difference;
    };

    return array_replace_recursive($arrayDiffRecursive($before, $after), $arrayDiffRecursive($after, $before, true));
}

echo '<pre>';
echo json_encode(config_diff($a, $b), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
