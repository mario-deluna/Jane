<?php
/**
 * Jane Iterator
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */
class Jane_Iterator
{
	/**
	 * The current code we want to iterate trough
	 *
	 * @var string
	 */
	protected $code = null;
	
	/**
	 * The code lenght to iterate
	 *
	 * @var int
	 */
	protected $length = 0;
	
	/**
	 * The current char 
	 *
	 * @var string
	 */
	protected $char = null;
	
	/**
	 * The last char 
	 *
	 * @var string
	 */
	protected $last_char = null;
	
	/**
	 * The next char 
	 *
	 * @var string
	 */
	protected $next_char = null;
	
	/**
	 * The current index
	 *
	 * @var string
	 */
	protected $index = 0;
	
	/**
	 * The current word 
	 *
	 * @var string
	 */
	protected $current_word = '';
	
	/**
	 * The last words 
	 *
	 * @var string
	 */
	protected $last_words = array();
	
	/**
	 * Are we in a single quetes string
	 *
	 * @var string
	 */
	protected $single_quotes_open = false;
	
	/**
	 * Are we in a double quetes string
	 *
	 * @var string
	 */
	protected $double_quotes_open = false;
	
	/**
	 * The constructor
	 *
	 * @var string 		$code
	 * @return void
	 */
	public function __construct( $code )
	{
		$this->code = $code;
		$this->length = strlen( $code );
	}
	
	/**
	 * Iterate to the next char
	 *
	 * @return bool
	 */
	public function next()
	{
		if ( $this->index >= $this->length )
		{
			return false;
		}
		
		// set the current char
		$this->char = $this->code[$this->index];
		
		// set the last char if possible
		if ( $this->index > 0 )
		{
			$this->last_char = $this->code[$this->index-1];
		}
		else 
		{
			$this->last_char = null;
		}
		
		// set the next char if possible
		if ( $this->index < $this->length-1 )
		{
			$this->next_char = $this->code[$this->index+1];
		}
		else 
		{
			$this->next_char = null;
		}
		
		// update the current jane word
		if ( preg_match('/^[a-zA-Z_\-\{\}\n]$/', $this->char ) )
		{
			$this->current_word .= $this->char;
		}
		else
		{
			if ( !empty( $this->current_word ) )
			{
				array_unshift( $this->last_words, $this->current_word );
				$this->current_word = '';
			}
		}
		
		// check if we are in a string
		if ( $this->char === '"' && $this->single_quotes_open === false )
		{
			if ( $this->double_quotes_open === true )
			{
				$this->double_quotes_open = false;
			}
			else
			{
				$this->double_quotes_open = true;
			}
		}
		if ( $this->char === "'" && $this->double_quotes_open === false )
		{
			if ( $this->single_quotes_open === true )
			{
				$this->single_quotes_open = false;
			}
			else
			{
				$this->single_quotes_open = true;
			}
		}
		
		// update the index
		$this->index++;
		
		// return success
		return true;
	}
	
	/**
	 * Returns the current char
	 *
	 * @return string
	 */
	public function char()
	{
		return $this->char;
	}
	
	/**
	 * Returns the last char
	 *
	 * @return string
	 */
	public function last_char()
	{
		return $this->last_char;
	}
	
	/**
	 * Returns the next char
	 *
	 * @return string
	 */
	public function next_char()
	{
		return $this->next_char;
	}
	
	/**
	 * Returns the last word
	 *
	 * @return string
	 */
	public function last_word( $i = 0 )
	{
		return $this->last_words[$i];
	}
	
	/**
	 * Returns the current word
	 *
	 * @return string
	 */
	public function current_word()
	{
		return $this->current_word;
	}
	
	/**
	 * Are we in a string
	 *
	 * @return bool
	 */
	public function in_string()
	{
		return !( $this->double_quotes_open === false && $this->single_quotes_open === false );
	}
}