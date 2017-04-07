<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\Form\Element\ValueRangeInterface;
use UForm\InvalidArgumentException;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Check that the string matches to given regexp
 */
class Regexp extends Validator
{

    const NO_MATCH = 'Regexp::NO_MATCH';

    protected $pattern;
    protected $message;

    /**
     * Regexp constructor.
     * @param string $pattern
     * @param string|null $message a custom message to show
     * instead of the default one when the data does not match the regexp
     */
    public function __construct($pattern, $message = null)
    {
        parent::__construct(null);


        if (!is_string($pattern)) {
            throw new InvalidArgumentException('set', 'string pattern', $pattern);
        }

        $this->pattern = $pattern;
        $this->message = $message;
    }


    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();

        if (null === $value) {
            $value = '';
        } elseif (!is_string($value)) {
            $message = new Message(
                'Invalid data',
                [],
                Validator::INVALID_DATA
            );
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
            return;
        }

        if (!preg_match($this->pattern, $value)) {
            if ($this->message) {
                $message = new Message(
                    $this->message,
                    [],
                    self::NO_MATCH
                );
            } else {
                $message = new Message(
                    'No match for regexp',
                    [],
                    self::NO_MATCH
                );
            }
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
