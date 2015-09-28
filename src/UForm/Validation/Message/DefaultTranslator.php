<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validation\Message;

use UForm\Validation\Message;

class DefaultTranslator implements TranslationInterface
{

    private static $defaultTranslator;

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

    /**
     * get a singleton translator used by default by the message
     * @return DefaultTranslator
     */
    public static function defaultTranslator()
    {
        if (null == self::$defaultTranslator) {
            self::$defaultTranslator = new DefaultTranslator();
        }
        return self::$defaultTranslator;
    }
}
