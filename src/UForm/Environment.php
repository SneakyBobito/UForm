<?php
/**
 * @license see LICENSE
 */

namespace UForm;

use UForm\Validation\Message\DefaultTranslator;
use UForm\Validation\Message\TranslationInterface;

abstract class Environment
{

    private static $translator;

    /**
     * set a global translator for message
     * @param TranslationInterface $translator
     */
    public static function setMessageTranslator(TranslationInterface $translator)
    {
        self::$translator = $translator;
    }

    /**
     * Get the global translation interface
     * @return TranslationInterface
     */
    public static function getTranslator()
    {
        if (null == self::$translator) {
            self::$translator = new DefaultTranslator();
        }
        return self::$translator;
    }

    /**
     * reset the environment at its default state
     */
    public static function reset()
    {
        self::$translator = null;
    }
}
