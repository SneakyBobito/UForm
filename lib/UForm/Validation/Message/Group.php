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
	protected $messages = [];

	/**
	 * Appends a message to the group
	 * @param Message $message the message to append
	 */
	public function appendMessage(Message $message)
	{
		$this->messages[] = $message;
	}

	/**
	 * @param $index
	 * @return null|Message
	 */
	public function getAt($index){
		return isset($this->messages[$index]) ? $this->messages[$index] : null;
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
		return count($this->messages);
	}


	public function getIterator()
	{
		return new \ArrayIterator($this->messages);
	}


}