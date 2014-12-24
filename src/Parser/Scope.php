<?php
/**
 * Jane Scope Parser
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 */
class Jane_Parser_Scope
{
	/**
	 * The current scope
	 *
	 * @var array
	 */
	protected $lines = array();
	
	/**
	 * The constructor
	 *
	 * @var string 		$code
	 * @return void
	 */
	public function __construct( $code )
	{
		$this->parse( $code );
	}
	
	/**
	 * The scope parser basically seperates lines and nest the scopes
	 *
	 * @var string 			$code
	 * @return void
	 */
	protected function parse( $code )
	{
		$iterator = new Jane_Iterator( $code );
		
		$lines = array();
		$line_index = 0;
		
		while ( $iterator->next() ) 
		{
			if ( !isset( $lines[$line_index] ) )
			{
				$lines[$line_index] = '';
			}
			
			if ( $iterator->char() === "\n" && !$iterator->in_string() )
			{
				$line_index++; continue;
			}
			
			$lines[$line_index] .= $iterator->char();
		}
		
		$scope = 0;
		
		// detect scopes in the lines
		foreach( $lines as $key => $line )
		{
			$line = trim( $line );
			
			
		}
		
		// assign the lines
		$this->lines = $lines;
	}
	
	/**
	 * Return the current lines
	 *
	 * @return Jane_Parser_Scope
	 */
	public function lines()
	{
		return $this->lines;
	}
}