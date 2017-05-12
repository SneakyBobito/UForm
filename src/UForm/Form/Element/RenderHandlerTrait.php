<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

trait RenderHandlerTrait
{

    private $renderHandlers_trait = [];

    public function addRenderOptionHandler(callable $callable)
    {
        $this->renderHandlers_trait[] = $callable;
    }

    public function processRenderOptionHandlers($localValue, $options)
    {
        foreach ($this->renderHandlers_trait as $renderHandler) {
            $options = call_user_func($renderHandler, $localValue, $options, $this);
        }
        return $options;
    }
}
