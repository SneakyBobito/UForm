<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

/**
 * Elements that implement this interface have the ability to be rendered without template
 */
interface Drawable
{
    public function render($localData, array $options = []);

    /**
     * Allows to modify options before render. Useful when some params need to depend on the values in render context
     * @param array $options
     * @return mixed
     */
    public function addRenderOptionHandler(callable $callable);
}
