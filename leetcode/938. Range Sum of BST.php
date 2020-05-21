<?php

class Solution
{
    /**
     * @param  TreeNode  $root
     * @param  Integer  $L
     * @param  Integer  $R
     * @return Integer
     */
    function rangeSumBST($root, $L, $R)
    {
        // root 沒有值 直接回傳 0
        if ($root === null) {
            return 0;
        }
        $res = 0;
        // root 在範圍內 左右都找 再加上 root 本身值
        if ($L <= $root->val && $root->val <= $R) {
            $res += $root->val;
            $res += $this->rangeSumBST($root->left, $L, $R);
            $res += $this->rangeSumBST($root->right, $L, $R);
        }
        // root 比 最小值 小 往右找
        elseif ($root->val < $L) {
            $res += $this->rangeSumBST($root->right, $L, $R);
        }
        // root 比 最大值 大 往左找
        elseif ($root->val > $R) {
            $res += $this->rangeSumBST($root->left, $L, $R);
        }
        return $res;
    }
}

Class Solution2{
    private $result = 0;
    function rangeSumBST($root, $L, $R)
    {
        // root 沒有值 跳過
        if ($root === null) {
            return $this->result;
        }
        // root 在範圍內就加上 root 本身的值
        if ($L <= $root->val && $root->val <= $R) {
            $this->result += $root->val;
        }
        // 每次左右都找 直到 root 沒有值
        $this->rangeSumBST($root->left, $L, $R);
        $this->rangeSumBST($root->right, $L, $R);

        return $this->result;
    }
}

class Solution3
{
    /**
     * @param  TreeNode  $root
     * @param  Integer  $L
     * @param  Integer  $R
     * @return Integer
     */
    function rangeSumBST($root, $L, $R)
    {
        $res = 0;
        // root 在範圍內加上 root 本身值
        if ($L <= $root->val && $root->val <= $R) {
            $res += $root->val;
        }
        // root 有在左範圍內 往左找
        if ($root->left && $root->val > $L) {
            $res += $this->rangeSumBST($root->left, $L, $R);
        }
        // root 有在右範圍內 往右找
        if ($root->right && $root->val < $R) {
            $res += $this->rangeSumBST($root->right, $L, $R);
        }
        return $res;
    }
}

class TreeNode
{
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($val = 0, $left = null, $right = null)
    {
        $this->val = $val;
        $this->left = $left;
        $this->right = $right;
    }
}
