<?php

namespace UForm\Form\Drawable;

/**
 * Elements that implement this interface have the ability to be rendered without template
 * Class Drawable
 * @package UForm\Form\Element
 */
interface Drawable {

    public function render($localValue, $data);

}