<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class Hidden
 * @semanticType input:hidden
 */
class Hidden extends Input
{

    protected $value;

    public function __construct($name, $value = null, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("hidden", $name, $attributes, $validators, $filters);
        $this->addSemanticType("input:hidden");
        $this->value = $value;
    }

    protected function overridesParamsBeforeRender($params, $attributes, $value, $prename = null)
    {
        $params = parent::overridesParamsBeforeRender($params, $attributes, $value, $prename);

        if ($this->value) {
            $params["value"] = $this->value;
        }
        return $params;
    }
}
