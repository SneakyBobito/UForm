<?php
/**
 * Created by PhpStorm.
 * User: sghzal
 * Date: 9/15/15
 * Time: 1:10 PM
 */

namespace UForm\Doc;


class NodeInfo {

    public $node;

    protected $hasNext = false;

    function __construct($node, $hasNext)
    {
        $this->node = $node;
        $this->hasNext = $hasNext;
    }

    public function hasNext(){
        return $this->hasNext;
    }

}