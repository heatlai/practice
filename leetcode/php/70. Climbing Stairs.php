<?php

class Solution
{
    /**
     * @param  Integer  $n
     * @return Integer
     */
    function climbStairs($n)
    {
        if ($n < 3) {
            return $n;
        }

        // 斐波那契數列 f(n)=f(n-1)+f(n-2)
        // 變成 f[n]=f[n-1]+f[n-2]
        $res[1] = 1;
        $res[2] = 2;
        for ($i = 3; $i <= $n; $i++) {
            $res[$i] = $res[$i - 1] + $res[$i - 2];
        }
        return $res[$n];
    }
}

echo (new Solution())->climbStairs(2)." => Expected 2".PHP_EOL;
echo (new Solution())->climbStairs(3)." => Expected 3".PHP_EOL;
echo (new Solution())->climbStairs(4)." => Expected 5".PHP_EOL;
