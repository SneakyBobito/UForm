<?php

namespace UForm\Forms\Element;

use UForm\Render\RenderContext;

/**
 * Elements that implement this interface have the ability to be rendered without template
 * Class Drawable
 * @package UForm\Forms\Element
 */
interface Drawable {

    public function render(RenderContext $context);

}