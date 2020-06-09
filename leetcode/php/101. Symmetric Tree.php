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
     * @param  TreeNode  $root
     * @return Boolean
     */
    function isSymmetric($root)
    {
        return $this->checkTree($root->left, $root->right);
    }

    function checkTree($p, $q)
    {
        if ( $p === null && $q === null) {
            return true;
        }
        if ( $p === null || $q === null || ($p->val !== $q->val)) {
            return false;
        }
        return $this->checkTree($p->left, $q->right) && $this->checkTree($p->right, $q->left);
    }
}

class Solution2
{

    /**
     * @param  TreeNode  $root
     * @return Boolean
     */
    function isSymmetric($root)
    {
        return $this->checkTree($root->left, $root->right);
    }

    /**
     * @param  TreeNode  $p
     * @param  TreeNode  $q
     * @return Boolean
     */
    function checkTree($p, $q)
    {
        if ($p === null && $q === null) {
            return true;
        }

        if ($p === null || $q === null || ($p->val !== $q->val)) {
            return false;
        }

        $p_queue = [$p];
        $q_queue = [$q];

        while ( ! empty($p_queue)) {
            $p_node = array_shift($p_queue);
            $q_node = array_shift($q_queue);

            if ( ! $this->isSameNodeValue($p_node->left, $q_node->right)) {
                return false;
            }

            if ($p_node->left !== null) {
                $p_queue[] = $p_node->left;
                $q_queue[] = $q_node->right;
            }

            if ( ! $this->isSameNodeValue($p_node->right, $q_node->left)) {
                return false;
            }

            if ($p_node->right !== null) {
                $p_queue[] = $p_node->right;
                $q_queue[] = $q_node->left;
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
