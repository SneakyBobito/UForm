<?php

namespace UForm\Forms\Group;


use UForm\Forms\Element\Group;
use UForm\Tag;

abstract class NamedGroup extends Group {

    protected $libelle;

    protected $class;

    protected $tagName;

    function __construct($tagName, $label = null, $elements = [] )
    {
        parent::__construct(null, $elements);
        $this->tagName = $tagName;
        $this->setUserOption("title", $label);
        $this->addSemanticType("namedGroup");
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    public function _render($attributes, $values, $data, $prename = null) {
        $prerender = parent::_render($attributes, $values, $data, $prename);

        $sectionTag = new Tag($this->tagName, array(
            "class" => $this->class
        ));

        return $sectionTag->draw(array(), $prerender);

    }

}