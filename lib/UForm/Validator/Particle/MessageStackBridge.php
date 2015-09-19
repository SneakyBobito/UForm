<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\Particle;

use Particle\Validator\MessageStack;
use UForm\Validation\Message;
use UForm\ValidationItem;

class MessageStackBridge extends MessageStack
{

    /**
     * @var ValidationItem
     */
    protected $validationItem;

    public function __construct(ValidationItem $validationItem)
    {
        $this->validationItem = $validationItem;
    }

    public function append($key, $reason, $message, array $parameters)
    {
        $message = new Message($message, $parameters, $reason);
        $this->validationItem->appendMessage($message);
    }
}
