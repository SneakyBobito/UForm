<?php

namespace UForm\Doc;


use RecursiveIterator;

class ElementTreeRecursiveIterator implements \RecursiveIterator{

    /**
     * @var ElementTreeNode
     */
    protected $nodes = [];
    protected $position = 0;

    function __construct(NodeContainer $nodes)
    {
        foreach($nodes->getNodes() as $node){

            $this->nodes[] = [$node, false];
            if($node->hasChildren()){
                $this->nodes[] = [$node, true];
            }

        }
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {

        $node = $this->nodes[$this->position][0];

        if($node->hasChildren()){
            $hasNext =  $this->position < (count($this->nodes) - 2);
        }else{
            $hasNext =  $this->position < (count($this->nodes) - 1);
        }

        return new NodeInfo($node, $hasNext);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->nodes[$this->position]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Returns if an iterator can be created for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.haschildren.php
     * @return bool true if the current entry can be iterated over, otherwise returns false.
     */
    public function hasChildren()
    {
        return $this->nodes[$this->position][1];
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Returns an iterator for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.getchildren.php
     * @return RecursiveIterator An iterator for the current entry.
     */
    public function getChildren()
    {
        return new self($this->current()->node);
    }


}