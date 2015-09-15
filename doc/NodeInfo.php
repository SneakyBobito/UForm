<?php

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