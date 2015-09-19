<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\Particle;

use Particle\Validator\Rule;
use UForm\Validator;

/**
 * This is a bridge that allows to use classes from particle validator
 * @see https://github.com/particle-php/Validator
 */
class RuleBridge extends Validator
{

    /**
     * @var Rule
     */
    protected $rule;

    public function __construct(Rule $rule, $options = null)
    {
        parent::__construct($options);
        $this->rule = $rule;
    }


    /**
     * @inheritdoc
     */
    public function validate(\UForm\ValidationItem $validationItem)
    {
        $this->rule->setMessageStack(new MessageStackBridge($validationItem));
        return $this->rule->validate($validationItem->getValue());
    }
}
