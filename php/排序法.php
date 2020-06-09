<?php

/**
 * QuickSort 快速排序法
 */

class QuickSort
{
    protected $array = [];

    public function __construct($array)
    {
        $this->array = $array;
    }

    public function get()
    {
        $low = 0;
        $high = count($this->array) - 1;
        $this->quickSort($low, $high);
        return $this->array;
    }

    protected function quickSort($low, $high)
    {
        // $low >= $high 表示 index 相撞，已經是最終結果
        if ($low < $high) {
            // 跑一次排序，return 軸心值
            $pivot = $this->partition($low, $high);
            // 遞迴左邊區塊跑排序
            $this->quickSort($low, $pivot - 1);
            // 遞迴右邊區塊跑排序
            $this->quickSort($pivot + 1, $high);
        }
    }

    protected function swap($a, $b)
    {
        [$this->array[$a], $this->array[$b]] = [$this->array[$b], $this->array[$a]];
        return $this;
    }

    protected function partition($low, $high)
    {
        // 用 $low 當軸心值
        $pivotValue = $this->array[$low];

        // 比 $pivot 大的放右邊，比 $pivot 小的放左邊
        while ($low < $high) {
            if ($low < $high && $this->array[$high] >= $pivotValue) {
                $high--;
            }
            $this->swap($low, $high);
            if ($low < $high && $this->array[$low] < $pivotValue) {
                $low++;
            }
            $this->swap($low, $high);
        }
        // $pivotValue 最後跑到哪個 index
        return $low;
    }

}

// 快速排序法 改良
class QuickSort2
{
    public const MAX_LENGTH_INSERTION_SORT = 7;
    protected $array = [];

    public function __construct($array)
    {
        $this->array = $array;
    }

    public function get()
    {
        $low = 0;
        $high = count($this->array) - 1;
        $this->quickSort($low, $high);
        return $this->array;
    }

    protected function quickSort($low, $high)
    {
        // 小於 MAX_LENGTH_INSERTION_SORT 就用插入排序法
        if (($high - $low) < static::MAX_LENGTH_INSERTION_SORT) {
            // $low >= $high 表示 index 相撞，已經是最終結果
            while ($low < $high) {
                // 跑一次排序，return 軸心值
                $pivot = $this->partition($low, $high);
                // 一直跑左邊區塊排序
                $this->quickSort($low, $pivot - 1);
                $low = $pivot + 1;
            }
        } else {
            // 使用插入排序法
            $this->insertionSort();
        }
    }

    protected function swap($a, $b)
    {
        [$this->array[$a], $this->array[$b]] = [$this->array[$b], $this->array[$a]];
        return $this;
    }

    protected function partition($low, $high)
    {
        // 改進 pivot 效率，$low 會變成 $low $mid $high 三個裡面的中間值
        $mid = floor($low + ($high - $low) / 2);
        if ($this->array[$low] > $this->array[$high]) {
            $this->swap($low, $high);
        }
        if ($this->array[$mid] > $this->array[$high]) {
            $this->swap($mid, $high);
        }
        if ($this->array[$low] < $this->array[$mid]) {
            $this->swap($low, $mid);
        }
        // 用 $low 當軸心值
        $pivotValue = $this->array[$low];

        // 比 $pivot 大的放右邊，比 $pivot 小的放左邊
        while ($low < $high) {
            if ($low < $high && $this->array[$high] >= $pivotValue) {
                $high--;
            }

            // $this->swap($low, $high);
            $this->array[$low] = $this->array[$high]; // 用替換代替交換，本來交換有很多次是不必要的
            if ($low < $high && $this->array[$low] < $pivotValue) {
                $low++;
            }
            // $this->swap($low, $high);
            $this->array[$high] = $this->array[$low];
        }

        echo "pivot : $low , pivot value: $pivotValue, ".json_encode($this->array).PHP_EOL;

        $arr[$low] = $pivotValue;    // 把軸心值寫回最後的 index
        // $pivotValue 最後跑到哪個 index
        return $low;
    }

    protected function insertionSort()
    {
        $len = count($this->array);
        // array 的第一個 value 當作初始陣列 array($arr[0])
        for ($i = 1; $i < $len; $i++) {
            $current = $this->array[$i];
            $index = $i - 1;
            while ($index >= 0 && $this->array[$index] > $current) {
                // 比較大的往後移
                $this->array[$index + 1] = $this->array[$index];
                $index--;
            }
            // 把 $current 寫回 正確index，前面 while 把比 $current 大的都往後移了
            $this->array[$index + 1] = $current;
        }
    }
}

// Array 寫法，用比較多空間
function quickSort(array $arr)
{
    $len = count($arr);
    if ($len <= 1) {
        return $arr;
    }
    $pivot = $arr[0];
    $left = array();
    $right = array();
    for ($i = 1; $i < $len; $i++) {
        if ($arr[$i] < $pivot) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }
    $left = quickSort($left);
    $right = quickSort($right);
    return array_merge($left, array($pivot), $right);
}

// 插入排序法 Insertion Sort
function insertionSort($arr)
{
    $len = count($arr);
    // array 的第一個 value 當作初始陣列 array($arr[0])
    for ($i = 1; $i < $len; $i++) {
        $current = $arr[$i];
        $index = $i - 1;
        while ($index >= 0 && $arr[$index] > $current) {
            // 比較大的往後移
            $arr[$index + 1] = $arr[$index];
            $index--;
        }
        // 把 $current 寫回 正確index，前面 while 把比 $current 大的都往後移了
        $arr[$index + 1] = $current;
    }
    return $arr;
}


// $arr = array(9, 1, 5, 8, 3, 7, 4, 6, 2);
// $arr = array(5, 4, 3, 2, 1);
$arr = array(1, 11, 18, 9, 4, 15, 17, 7, 6, 19, 14, 8, 3, 2, 13, 20, 5, 10, 16, 12);

echo "input: ".json_encode($arr).PHP_EOL;
echo "res: ".json_encode(quickSort($arr)).PHP_EOL;
echo "res: ".json_encode((new QuickSort($arr))->get()).PHP_EOL;
echo "res: ".json_encode((new QuickSort2($arr))->get()).PHP_EOL;
echo "res: ".json_encode(insertionSort($arr)).PHP_EOL;
