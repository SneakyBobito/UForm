<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validation\Message;

use UForm\Validation\Message;

interface TranslationInterface
{

    public function translate(Message $message);
}
