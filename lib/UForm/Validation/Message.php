<?php

namespace UForm\Validation;

class Message
{
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
     * @var null|string
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
                $message = str_replace("%_${k}_%", $v, $message);
            }
        }
        return $message;
    }

    /**
     * @return []
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
