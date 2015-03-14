<?php namespace Jane;
/**
 * Jane Token Iterator
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */

use Jane\Scope\Variable;
use Jane\Exception;

class TokenIterator
{
	/**
	 * The tokens in this code segment
	 *
	 * @var array[Jane\Node]
	 */
	protected $tokens = array();
	
	/**
	 * The current index while parsing trough the tokens
	 * 
	 * @var int
	 */
	protected $index = 0;
	
	/**
	 * The number of tokens to parse
	 * 
	 * @var int
	 */
	protected $tokenCount = 0;
	
	/**
	 * Retrives the current token based on the index
	 *
	 * @return Jane\Node
	 */
	protected function currentToken()
	{
		return $this->tokens[ $this->index ];
	}
	
	/**
	 * Get the next token based on the current index
	 * If the token does not exist because its off index "false" is returend.
	 *
	 * @param int 					$i
	 * @return Jane\Node|false
	 */
	protected function nextToken( $i = 1 )
	{
		if ( !isset( $this->tokens[ $this->index + $i ] ) )
		{
			return false;
		}
		
		return $this->tokens[ $this->index + $i ];
	}
	
	/**
	 * Skip the next parser token by updating the index.
	 *
	 * @param int			$times
	 * @return void
	 */
	protected function skipToken( $times = 1 )
	{
		$this->index += $times;
	}
	
	/**
	 * Check if all tokens have been parsed trough
	 *
	 * @return bool
	 */
	protected function iteratorIsDone()
	{
		return $this->index >= $this->tokenCount;
	}
	
	/**
	 * Create new token Iterator with nodes until a node with type shows up
	 *
	 * @param string|array 				$nodeTypes
	 */ 
	protected function createTokenIteratorUntil( $nodeTypes )
	{
		if ( !is_array( $nodeTypes ) )
		{
			$nodeTypes = array( $nodeTypes );
		}
		
		$tokens = array();
		
		while ( !$this->iteratorIsDone() && !in_array( $this->currentToken()->type, $nodeTypes ) ) 
		{
			$tokens[] = $this->currentToken(); $this->skipToken();	
		}
		
		return $tokens;
	}
}