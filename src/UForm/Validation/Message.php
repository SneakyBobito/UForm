<?php

namespace UForm\Validation;

use UForm\Environment;
use UForm\Validation\Message\TranslationInterface;

class Message
{

    protected $variablePlaceholderBefore = "%_";
    protected $variablePlaceholderAfter  = "_%";

    /**
     * @var null|string
     */
    protected $type;

    /**
     * @var null|string
     */
    protected $message;

    /**
     * @var []
     */
    protected $variables = [];

    /**
     * @var TranslationInterface
     */
    protected $translator;

    /**
     * @param string $message
     * @param array|null $variables
     * @param string|null $type
=     */
    public function __construct($message, array $variables = null, $type = null)
    {
        $this->message = $message;
        $this->variables = $variables;
        $this->type = $type;
    }

    /**
     * Set a translationInterface that will be used to translate message in method getProcessedMessage
     * @see Message::getProcessedMessage()
     * @param TranslationInterface $translator
     */
    public function setTranslator(TranslationInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Gets the internal translator
     * if no translator was set, then a translator from environment will be returned
     * @see UForm\Validation\Message\DefaultTranslator
     * @return TranslationInterface
     */
    public function getTranslator()
    {
        if ($this->translator) {
            $translator = $this->translator;
        } else {
            $translator = Environment::getTranslator();
        }
        return $translator;
    }


    /**
     * Returns message type
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * changes the variableplaceholder before
     * Default to %_
     * @param string $variablePlaceholderBefore
     */
    public function setVariablePlaceholderBefore($variablePlaceholderBefore)
    {
        $this->variablePlaceholderBefore = $variablePlaceholderBefore;
    }

    /**
     * changes the variableplaceholder after
     * Default to _%
     * @param string $variablePlaceholderAfter
     */
    public function setVariablePlaceholderAfter($variablePlaceholderAfter)
    {
        $this->variablePlaceholderAfter = $variablePlaceholderAfter;
    }



    /**
     * gets the message without processing vars
     *
     * @return string
     */
    public function getMessageRaw()
    {
        return $this->message;
    }

    /**
     * Gets the message processed with the internal variables
     * If a translator was set, the message will be passed to the translator
     * @see Message::setTranslator()
     * @return string the message processed
     */
    public function getProcessedMessage()
    {
        return $this->getTranslator()->translate($this);
    }

    /**
     * create a variable name
     * @param $variableName
     * @return string
     */
    public function makePlaceholder($variableName)
    {
        return $this->variablePlaceholderBefore . $variableName . $this->variablePlaceholderAfter;
    }

    /**
     * get the variables of the message
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Magic __toString method returns verbose message
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getProcessedMessage();
    }
}
