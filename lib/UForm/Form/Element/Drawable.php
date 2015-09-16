<?php

namespace UForm\Form\Element;

/**
 * Elements that implement this interface have the ability to be rendered without template
 * Class Drawable
 * @package UForm\Form\Element
 */
interface Drawable {

    public function render($localValue, $data);

}