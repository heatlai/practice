<?php

// 把值全部取出來，排序完，新建 ListNode
class Solution
{

    /**
     * @param  ListNode  $l1
     * @param  ListNode  $l2
     * @return ListNode
     */
    function mergeTwoLists($l1, $l2)
    {
        if ($l1 === null) {
            return $l2;
        }

        if ($l2 === null) {
            return $l1;
        }

        $tmp = [];
        $this->getRecursive($tmp, $l1->val, $l1->next);
        $this->getRecursive($tmp, $l2->val, $l2->next);

        $len = count($tmp);
        if ($len === 0) {
            return null;
        }

        sort($tmp);
        $lastIndex = $len - 1;
        $node = new ListNode($tmp[$lastIndex]);
        for ($i = $lastIndex - 1; $i > -1; --$i) {
            $node = new ListNode($tmp[$i], $node);
        }

        return $node;
    }

    /**
     * @param $tmp
     * @param  int  $val
     * @param  ListNode  $next
     */
    function getRecursive(&$tmp, $val, $next)
    {
        $tmp[] = $val;
        if ($next) {
            $this->getRecursive($tmp, $next->val, $next->next);
        }
    }
}

// 用原本兩個 ListNode 交錯比對塞進 next
class Solution2
{

    /**
     * @param  ListNode  $l1
     * @param  ListNode  $l2
     * @return ListNode
     */
    function mergeTwoLists($l1, $l2)
    {
        if ($l1 === null) {
            return $l2;
        }

        if ($l2 === null) {
            return $l1;
        }

        // 起始值小的當第一個node
        if ($l1->val <= $l2->val) {
            $resultNode = $l1;
            $currentNode = $l1;
            $pendingNode = $l2;
        } else {
            $resultNode = $l2;
            $currentNode = $l2;
            $pendingNode = $l1;
        }
        while ($nextNode = $currentNode->next) {
            // 如果 $nextNode->val 小於等於 $pendingNode->val
            // 就跳過這個 node，把 nextNode 變成 currentNode
            if ($nextNode->val <= $pendingNode->val) {
                $currentNode = $nextNode;
            // 如果 $nextNode->val 大於 $pendingNode->val 把 $pendingNode 塞進 $currentNode 的 next
            // 然後 $pendingNode 變成 $currentNode，做下一圈計算
            // 原本的 $nextNode 變成 $pendingNode 等待下一次比大小
            } else {
                $currentNode->next = $pendingNode;
                $currentNode = $pendingNode;
                $pendingNode = $nextNode;
            }
        }
        // 把最後一個 $pendingNode 塞進去
        $currentNode->next = $pendingNode;
        return $resultNode;
    }
}

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
