<?php

$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('n');

//本月第一天是星期幾
$first_day = date('w', mktime(0, 0, 0, $month, 1, $year));
//本月最後一天是星期幾
$last_day = date('w', mktime(0, 0, 0, $month + 1, 0, $year));
//本月總共有幾天
$days = date('t', mktime(0, 0, 0, $month, 1, $year));
//上月最後一天
$last_month_day = date('d', mktime(0, 0, 0, $month, 0, $year));

//上一年
function prev_year($year, $month)
{
    $year--;
    if ($year < 1970) $year = 1970;
    return "?year={$year}&month={$month}";
}

//下一年
function next_year($year, $month)
{
    $year++;
    return "?year={$year}&month={$month}";
}

//上個月
function prev_month($year, $month)
{
    if ($month == 1)
    {
        $month = 12;
        $year--;
        if ($year < 1970)
        {
            $year = 1970;
            $month = 1;
        }
    }
    else
    {
        $month--;
    }
    return "?year={$year}&month={$month}";
}

//下個月
function next_month($year, $month)
{
    if ($month == 12)
    {
        $month = 1;
        $year++;
    }
    else
    {
        $month++;    
    }
    return "?year={$year}&month={$month}";
}


echo "
    <table>
    <tr>
    <th><a href=\"" . prev_year($year, $month) . "\">上年</a></th>
    <th><a href=\"" . prev_month($year, $month) . "\">上月</a></th>
    <th colspan=3 align=center><b>{$year} - " . sprintf('%02d', $month) . "</b></th>
    <th><a href=\"" . next_month($year, $month) . "\">下月</a></th>
    <th><a href=\"" . next_year($year, $month) . "\">下年</a></th>
    </tr>
    <tr>
    <th>Sun</th>
    <th>Mon</th>
    <th>Tue</th>
    <th>Wed</th>
    <th>Thu</th>
    <th>Fri</th>
    <th>Sat</th>
    </tr>
    ";

//補滿本月前的日期
for ($i = $first_day - 1; $i >= 0; $i--)
{ 
    echo '<td align=center><font color=AAAAAA>' . sprintf('%02d', ($last_month_day - $i)) . '</font></td>';
}

//填入本月日期
//存放下一格是第幾格
$grid = $first_day;
for ($j = 1; $j <= $days; $j++)
{ 
    echo '<td align=center><font color=000088>' . sprintf('%02d', $j) . '</font></td>';

    //下一格被7整除就換行
    $grid++;
    if ($grid % 7 == 0)
    {
        echo '</tr><tr>';
    }
}
//補滿本月後的日期
for ($i = 1; $i < 7; $i++)
{    
    //下一格被7整除就停止
    if($grid % 7 == 0) break;
    $grid++;

    echo '<td align=center><font color=AAAAAA>' . sprintf('%02d', $i) . '</font></td>';
}
echo '</table>';