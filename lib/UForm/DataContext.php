<?php
/**
 * @license see LICENSE
 */

namespace UForm;

class DataContext implements \IteratorAggregate
{

    /**
     * @var array
     */
    protected $data;

    /**
     * @var Navigator
     */
    protected $navigator;

    /**
     * @var bool
     */
    protected $isArray;

    /**
     * @param Form $form
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->navigator = new Navigator();
        $this->isArray = is_array($data);
    }

    /**
     * Find a value by it's name accepting dotted path.
     * If you are sure that the value you want to get is a direct value,
     * please consider using getDirectValue for performance purposes
     * @param string $path the path of the data, accepts dotted notation
     * @return mixed the value
     */
    public function findValue($path)
    {
        if (!$this->isArray()) {
            return null;
        }
        return $this->navigator->arrayGet($this->data, $path);
    }

    /**
     * Find a value located directly in the scope (not recursively)
     * @param string $name
     * @return null
     */
    public function getDirectValue($name)
    {
        if (!$this->isArray()) {
            return null;
        }
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->isArray() ? $this->data : []);
    }

    /**
     * Get a copy of the internal data array
     * @return array the data
     */
    public function getDataCopy()
    {
        return $this->data;
    }

    /**
     * check if the internal data is an array
     * @return bool true if the internal data is an array
     */
    public function isArray()
    {
        return $this->isArray;
    }
}
