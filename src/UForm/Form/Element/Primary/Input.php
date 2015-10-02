<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary;

use Symfony\Component\Config\Tests\Loader\Validator;
use UForm\Filter;
use UForm\Form\Element;
use UForm\Form\Element\Drawable;
use UForm\Form\Element\Primary;
use UForm\Tag;

/**
 * That a general class to simplify the code of element using the tag input
 * @semanticType input
 */
class Input extends Primary implements Drawable
{

    private $inputType;

    /**
     * @param string $type type of the input (text, password, radio,...)
     * @param string $name name of the input in the form
     * @param array $attributes
     * @param Validator[] $validators
     * @param Filter[] $filters
     */
    public function __construct($type, $name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->inputType = $type;
        $this->addSemanticType("input");
    }


    /**
     * @inheritdoc
     */
    public function render($localValue, array $options = [])
    {


        $params = [
            "type" => $this->inputType,
            "name" => $this->getName(true),
            "id"   => $this->getId()
        ];

        if (isset($options["attributes"]) && is_array($options["attributes"])) {
            foreach($options["attributes"] as $attrName => $attrValue){
                $params[$attrName] = $attrValue;
            }
        }
        if (isset($options["class"])) {
            $params["class"] = $options["class"];
        }

        if (is_array($localValue) && isset($localValue[$this->getName()])) {
            $params["value"] = $localValue[$this->getName()];
        }

        $render = new Tag("input", $this->overridesParamsBeforeRender($params, [], $localValue), true);

        return $render->draw([], null);
    }

    /**
     * allows subclasses to redefine some params before the rendering
     * (e.g checkbox will use 'checked' instead of 'value')
     * @param $params
     * @param $attributes
     * @param $value
     * @param $data
     * @param null $prename
     * @return mixed
     */
    protected function overridesParamsBeforeRender($params, $attributes, $value, $prename = null)
    {
        return $params;
    }
}
