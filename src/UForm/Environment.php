<?php
/**
 * @license see LICENSE
 */

namespace UForm;

use UForm\Validation\Message\DefaultTranslator;
use UForm\Validation\Message\TranslationInterface;
use UForm\Validator\Csrf\CsrfInterface;

abstract class Environment
{

    /**
     * @var TranslationInterface
     */
    private static $translator;

    /**
     * @var CsrfInterface
     */
    private static $csrf;

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
     * Set a global csrf resolver
     * @param CsrfInterface $csrfInterface
     */
    public static function setCsrfResolver(CsrfInterface $csrfInterface)
    {
        self::$csrf = $csrfInterface;
    }

    /**
     * @return CsrfInterface|null
     */
    public static function getCsrfResolver()
    {
        return self::$csrf;
    }

    /**
     * reset the environment at its default state
     */
    public static function reset()
    {
        self::$translator = null;
        self::$csrf = null;
    }
}
