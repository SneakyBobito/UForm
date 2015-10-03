<?php
/**
 * @license see LICENSE
 */

namespace UForm\Doc;


class RenderOptionInformation {

    protected $name;
    protected $info;

    function __construct($name, $info)
    {
        $this->name = $name;
        $this->info = $info;
    }


    public static function fromString($string){
        $stringParts = explode(" ", $string);
        return new RenderOptionInformation($stringParts[0], $stringParts[1]);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }



}
