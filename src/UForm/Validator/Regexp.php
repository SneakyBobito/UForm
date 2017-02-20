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

    /**
     * @param array|ValueRangeInterface $range
     */
    public function __construct($pattern)
    {
        parent::__construct(null);

        if (!is_string($pattern)) {
            throw new InvalidArgumentException('set', 'string pattern', $pattern);
        }

        $this->pattern = $pattern;
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
            $message = new Message(
                'No match for regexp',
                [],
                self::NO_MATCH
            );
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
