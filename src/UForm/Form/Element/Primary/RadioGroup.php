<?php

namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Validation;

/**
 * @semanticType radioGroup
 */
class RadioGroup extends Element implements Element\Drawable
{

    protected $values;
    protected $generatedIds = [];

    public function __construct($name, $values, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->values = $values;
        $this->addSemanticType("radioGroup");
    }

    public function render($value, $data)
    {
        $renderHtml = "";

        $i=0;

        foreach ($this->values as $k => $v) {
            $id = $this->getId($i);
            $labelTag = new \UForm\Tag("label");
            $renderHtml .= $labelTag->draw([
                "for" => $id
            ], $v);

            $cbTag = new \UForm\Tag("input", [
                "type" => "radio",
                "name" => $this->getName()
            ], true);


            $renderProp = [
                "id" => $id,
                "value" => $k
            ];

            if (isset($value[$this->getName()]) && $value[$this->getName()] == $k) {
                $renderProp["checked"] = "checked";
            }

            $renderHtml .= $cbTag->draw($renderProp);
            $i++;
        }

        return $renderHtml;

    }

    /**
     * It will generate and store an html id for the given index. The generated id is stored for the index
     * and the second call with the same index wont generate a new id, instead it will return
     * the previously generated one
     * Useful for rendering label's for attribute and input's id attribute.
     * @param int $index to generate an id for
     * @return string
     */
    public function getId($index){
        if(!isset($this->generatedIds[$index])){
            $this->generatedIds[$index] = $this->getName() . $index . rand(1000, 9999);
        }
        return $this->generatedIds[$index];
    }

    public function getValueRange()
    {
        return array_keys($this->values);
    }
}
