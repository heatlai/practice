<?php

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
class Solution
{

    /**
     * @param  ListNode  $head
     * @return ListNode
     */
    function deleteDuplicates($head)
    {
        $current = $head;
        while ($next = $current->next) {
            while($next->val === $current->val) {
                $next = $next->next;
            }
            $current->next = $next;
            $current = $current->next;
        }
        return $head;
    }
}

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
