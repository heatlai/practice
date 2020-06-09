<?php

/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
class Solution
{

    /**
     * @param  TreeNode  $p
     * @param  TreeNode  $q
     * @return Boolean
     */
    function isSameTree($p, $q)
    {
        // php 兩等於 object
        // 兩個 object 的屬性和屬性值 都相等，而且兩個 object 是同一個 class 的實例
        return $p == $q;
    }
}

// 遞迴
class Solution2
{

    /**
     * @param  TreeNode  $p
     * @param  TreeNode  $q
     * @return Boolean
     */
    function isSameTree($p, $q)
    {
        if ($p === null && $q === null) {
            return true;
        }
        if ($p === null || $q === null) {
            return false;
        }
        if ($p->val !== $q->val) {
            return false;
        }
        return $this->isSameTree($p->left, $q->left) && $this->isSameTree($p->right, $q->right);
    }
}

// 迴圈 + Queue
class Solution3
{

    /**
     * @param  TreeNode  $p
     * @param  TreeNode  $q
     * @return Boolean
     */
    function isSameTree($p, $q)
    {
        if ($p === null && $q === null) {
            return true;
        }

        if ($p === null || $q === null) {
            return false;
        }

        if ($p->val !== $q->val) {
            return false;
        }

        $p_queue = [$p];
        $q_queue = [$q];

        while ( ! empty($p_queue)) {
            $p_node = array_shift($p_queue);
            $q_node = array_shift($q_queue);

            if ( ! $this->isSameNodeValue($p_node->left, $q_node->left)) {
                return false;
            }

            if ($p_node->left !== null) {
                $p_queue[] = $p_node->left;
                $q_queue[] = $q_node->left;
            }

            if ( ! $this->isSameNodeValue($p_node->right, $q_node->right)) {
                return false;
            }

            if ($p_node->right !== null) {
                $p_queue[] = $p_node->right;
                $q_queue[] = $q_node->right;
            }
        }

        return true;
    }

    function isSameNodeValue($p, $q)
    {
        if ($p === null && $q === null) {
            return true;
        }

        if ($p === null || $q === null) {
            return false;
        }

        return ($p->val === $q->val);
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
