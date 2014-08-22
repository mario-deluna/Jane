<?php
/**
 * Jane Vars Compiler
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
class Jane_Compiler_Vars extends Jane_Compiler_Base implements Jane_Compiler_Interface
{
	/**
	 * Array of comparsion chars
	 *
	 * @var array
	 */
	protected $comparsion_chars = array(
		'=', '!', '<', '>'
	);
	
	/**
	 * return the compiled code
	 *
	 * @return string
	 */
	public function compile()
	{
		$buffer = "";
		
		$iterator = new Jane_Iterator( $this->code );
		
		$known_vars = array();
		
		// iterate trough code
		while( $iterator->next() )
		{
			// when we have an equal char
			if ( $iterator->char() === '=' )
			{
				// check that is no comparsion
				if 
				(
					!in_array( $iterator->last_char(), $this->comparsion_chars ) 
					&& !in_array( $iterator->next_char(), $this->comparsion_chars ) 
					&& !$iterator->in_string()
				)
				{
					$known_vars[] = $iterator->last_word();
				}
			}
			
			$buffer .= $iterator->char();
		}
		
		// now replace all know vars with the $ prefix
		foreach( $known_vars as $var )
		{
			$buffer = str_replace( $var, '$'.$var, $buffer );
		}
		
		return $buffer;
	}
}