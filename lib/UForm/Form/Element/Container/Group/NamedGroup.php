<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group;
use UForm\Tag;

/**
 * Class NamedGroup
 * @semanticType namedGroup
 */
abstract class NamedGroup extends Group
{

    protected $libelle;

    protected $class;

    protected $tagName;

    public function __construct($tagName, $label = null, $elements = [])
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

    public function __render($attributes, $values, $data, $prename = null)
    {
        $prerender = parent::__render($attributes, $values, $data, $prename);

        $sectionTag = new Tag($this->tagName, [
            "class" => $this->class
        ]);

        return $sectionTag->draw([], $prerender);

    }
}
