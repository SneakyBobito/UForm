<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validation\Message;

use UForm\Validation\Message;

class DefaultTranslator implements TranslationInterface
{



    /**
     * @inheritdoc
     */
    public function translate(Message $message)
    {
        $messageString = $message->getMessageRaw();
        foreach ($message->getVariables() as $k => $v) {
            $messageString = str_replace($message->makePlaceholder($k), $v, $messageString);
        }
        return $messageString;
    }
}
