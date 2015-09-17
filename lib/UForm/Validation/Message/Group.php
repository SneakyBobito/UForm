<?php
/**
 * Group
 *
 */
namespace UForm\Validation\Message;

use Countable;
use UForm\Validation\Message;
use UForm\Validation\MessageInterface;

/**
 * Represents a group of validation messages
 * 
 */
class Group implements Countable, \IteratorAggregate
{

	/**
	 * Messages
	 * 
	 * @var null|array
	 * @access protected
	*/
	protected $_messages;

	/**
	 * Appends a message to the group
	 * @param Message $message the message to append
	 */
	public function appendMessage(Message $message)
	{
		$this->_messages[] = $message;
	}

	/**
	 * Appends an array of messages to the group
	 * @param Message[] $messages array of messages to append
	 */
	public function appendMessages($messages)
	{
		foreach($messages as $message){
			$this->appendMessage($message);
		}
	}

	/**
	 * Returns the number of messages in the list
	 * @return int
	 */
	public function count()
	{
		return count($this->_messages);
	}


	public function getIterator()
	{
		return new \ArrayIterator($this->_messages);
	}


}