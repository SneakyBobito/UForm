<?php
/**
 * @license see LICENSE
 */

namespace UForm;


use Traversable;

class DataContext implements \IteratorAggregate {

    /**
     * @var array
     */
    protected $data;

    /**
     * @var Navigator
     */
    protected $navigator;

    /**
     * @param Form $form
     * @param $data
     */
    function __construct($data)
    {
        $this->data = $data;
        $this->navigator = new Navigator();
    }

    /**
     * Find a value by it's name accepting dotted path.
     * If you are sure that the value you want to get is a direct value, please consider using getDirectValue for performance purposes
     * @param string $path the path of the data, accepts dotted notation
     * @return mixed the value
     */
    public function findValue($path){
        return $this->navigator->arrayGet($this->data, $this->data, $path);
    }

    /**
     * Find a value located directly in the scope (not recursively)
     * @param string $name
     * @return null
     */
    public function getDirectValue($name){
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function getArrayCopy(){
        return $this->data;
    }


}