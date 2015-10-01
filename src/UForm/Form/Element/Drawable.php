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
}
