<?php
/**
 * @license see LICENSE
 */

namespace UForm\DataBind;

abstract class Binder
{

    protected $whitelist = null;
    protected $blacklist = [];

    /**
     * @param array $whitelist
     */
    public function setWhitelist($whitelist)
    {
        $this->whitelist = $whitelist;
    }

    /**
     * @param array $blacklist
     */
    public function setBlacklist($blacklist)
    {
        $this->blacklist = $blacklist;
    }

    /**
     * binds the given data on the internal target
     * @param $data
     */
    public function bind($data)
    {

        foreach ($data as $key => $value) {
            //Check if the item is in the whitelist
            if ($this->whitelist !== null && !in_array($key, $this->whitelist)) {
                continue;
            }

            if (in_array($key, $this->blacklist)) {
                continue;
            }

            $this->bindKey($key, $value);
        }
    }

    abstract protected function bindKey($key, $value);
}
