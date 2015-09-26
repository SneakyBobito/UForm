<?php

namespace UForm\Validation;

class Message
{

    protected $variablePlaceholderBefore = "%_";
    protected $variablePlaceholderAfter  = "_%";

    /**
     * Type
     *
     * @var null|string
     * @access protected
    */
    protected $type;

    /**
     * Message
     *
     * @var null|string
     * @access protected
    */
    protected $message;

    /**
     * Field
     *
     * @var []
     * @access protected
    */
    protected $variables = [];

    /**
     * @param string $message
     * @param array|null $variables
     * @param string|null $type
     * @throws Exception
     */
    public function __construct($message, array $variables = null, $type = null)
    {
        $this->message = $message;
        $this->variables = $variables;
        $this->type = $type;
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
     * get the message processed with the interval variables
     * @return string the message processed
     */
    public function getProcessedMessage()
    {
        $message = $this->message;
        foreach ($this->variables as $variable) {
            foreach ($this->variables as $k => $v) {
                $message = str_replace($this->makePlaceholder($k), $v, $message);
            }
        }
        return $message;
    }

    /**
     * create a variable name
     * @param $variableName
     * @return string
     */
    private function makePlaceholder($variableName)
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
