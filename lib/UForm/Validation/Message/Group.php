<?php
/**
 * Group
 *
 */
namespace UForm\Validation\Message;

use ArrayAccess;
use Countable;
use Iterator;
use UForm\Validation\Message;
use UForm\Validation\MessageInterface;

/**
 * Represents a group of validation messages
 * 
 */
class Group implements Countable, ArrayAccess, Iterator
{
	/**
	 * Position
	 * 
	 * @var null|int
	 * @access protected
	*/
	protected $_position;

	/**
	 * Messages
	 * 
	 * @var null|array
	 * @access protected
	*/
	protected $_messages;

	/**
	 * \UForm\Validation\Message\Group constructor
	 *
	 * @param array|null $messages
	 */
	public function __construct($messages = null)
	{
		if(is_array($messages) === true) {
			$this->_messages = $messages;
		} else {
			$this->_messages = array();
		}
	}

        /**
         * Gets an attribute a message using the array syntax
         *
         *<code>
         * print_r($messages[0]);
         *</code>
         *
         * @param string $index
         * @return \UForm\Validation\Message|null
         * @throws Exception
         */
        public function offsetGet($index)
        {

            if(isset($this->_messages[$index]) === true) {
                return $this->_messages[$index];
            }

            return null;
        }

        /**
         * Sets an attribute using the array-syntax
         *
         *<code>
         * $messages[0] = new \UForm\Validation\Message('This is a message');
         *</code>
         *
         * @param string $index
         * @param \UForm\Validation\Message $message
         * @throws Exception
         */
        public function offsetSet($index, $message)
        {
            if(is_object($message) === false &&
                $message instanceof Message === false) {
                throw new Exception('The message must be an object');
            }

            $this->_messages[$index] = $message;
        }

	/**
	 * Checks if an index exists
	 *
	 *<code>
	 * var_dump(isset($message['database']));
	 *</code>
	 *
	 * @param string $index
	 * @return boolean
	 * @throws Exception
	 */
	public function offsetExists($index)
	{
                if(is_string($index) === false) {
                    throw new Exception('Invalid parameter type.');
                }

                return isset($this->_messages[$index]);
	}

        /**
         * Removes a message from the list
         *
         *<code>
         * unset($message['database']);
         *</code>
         *
         * @param string $index
         * @throws Exception
         */
        public function offsetUnset($index)
        {
            if(is_string($index) === false) {
                throw new Exception('Invalid parameter type.');
            }

            unset($this->_messages[$index]);
        }

	/**
	 * Appends a message to the group
	 *
	 *<code>
	 * $messages->appendMessage(new \UForm\Validation\Message('This is a message'));
	 *</code>
	 *
	 * @param \UForm\Validation\MessageInterface $message
	 * @throws Exception
	 */
	public function appendMessage(Message $message)
	{
		$this->_messages[] = $message;
	}

	/**
	 * Appends an array of messages to the group
	 *
	 *<code>
	 * $messages->appendMessages($messagesArray);
	 *</code>
	 *
	 * @param \UForm\Validation\MessageInterface[]|array $messages
	 * @throws Exception
	 */
	public function appendMessages($messages)
	{
		if(is_array($messages) === false) {
			if(is_object($messages) === false ||
				$messages instanceof MessageInterface === false) {
				throw new Exception('The message must be array or object');
			}
		}

		if(is_array($messages) === true) {
			//An array of messages is simply merged into the current one
			$this->_messages = array_merge($this->_messages, $messages);
		} else {
			//A group of messages is iterated and appended one-by-one to the current list
			$messages->rewind();

			while($messages->valid() !== false) {
				$this->appendMessage($messages->current());
				$messages->next();
			}
		}
	}



	/**
	 * Returns the number of messages in the list
	 *
	 * @return int
	 */
	public function count()
	{
            return count($this->_messages);
	}

	/**
	 * Rewinds the internal iterator
	 */
	public function rewind()
	{
            $this->_position = 0;
	}

	/**
	 * Returns the current message in the iterator
	 *
	 * @return \UForm\Validation\Message|null
	 */
	public function current()
	{
            if(isset($this->_messages[$this->_position]) === true) {
                return $this->_messages[$this->_position];
            }

            return null;
	}

	/**
	 * Returns the current position/key in the iterator
	 *
	 * @return int|null
	 */
	public function key()
	{
            return $this->_position;
	}

	/**
	 * Moves the internal iteration pointer to the next position
	 */
	public function next()
	{
            ++$this->_position;
	}

	/**
	 * Check if the current message in the iterator is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
            return isset($this->_messages[$this->_position]);
	}

	/**
	 * Magic __set_state helps to re-build messages variable when exporting
	 *
	 * @param array $group
	 * @return \UForm\Mvc\Model\Message\Group
	 * @throws Exception
	 */
	public static function __set_state($group)
	{
            if(is_array($group) === false) {
                throw new Exception('Invalid parameter type.');
            }

            return new Group($group['_messages']);
	}
}