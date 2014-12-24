<?php
/**
 * Jane Base Compiler
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
class Jane_Compiler_Base
{
	/**
	 * The code 
	 *
	 * @var string
	 */
	protected $code = '';
	
	/**
	 * Recive the code 
	 *
	 * @param string 		$code
	 * @return void 
	 */
	public function __construct( $code )
	{
		$this->code = $code;
	}
	
	/**
	 * Parse and transform arguments
	 *
	 * @param string 		$arguments
	 * @return string
	 */
	protected function parse_arguments( $arguments )
	{	
		$arguments = trim( $arguments );
		
		$in_string = false;
		
		$word_index = 0;
		
		$split = array();
		
		for ( $i=0;$i<strlen( $arguments );$i++ )
		{
			$char = $arguments[$i];
			
			if ( $char === '"' || $char === "'" )
			{
				if ( $in_string === false )
				{
					$in_string = $char;
				}
				else
				{
					if ( $in_string === $char )
					{
						$in_string = false;
					}
				}
			}
			
			if ( $char == ',' && $in_string === false )
			{
				$word_index++;
			}
			else 
			{
				if ( !isset( $split[$word_index] ) )
				{
					$split[$word_index] = '';
				}
				
				$split[$word_index] .= $char;
			}
		}
		
		$arguments = $split;
		
		foreach( $arguments as $key => $argument )
		{
			$arguments[$key] = $this->format_argument( trim( $argument ) );
		}
		
		return implode( ', ', $arguments );
	}
	
	/**
	 * Format an arguments
	 *
	 * @param string 		$argument
	 * @return string
	 */
	protected function format_argument( $argument )
	{
		// closure always ends with }
		if ( strpos( $argument, '{' ) !== false && substr( $argument, -1 ) == '}' )
		{
			$parameters = substr( $argument, 0, strpos( $argument, '{' ) );
			$closure = substr( $argument, strpos( $argument, '{' )+1, -1 );
			
			$parameters = $this->parse_arguments( $parameters );
			
			if ( !empty( $parameters) )
			{
				$parameters = ' '.$parameters.' ';
			}
			
			$argument = 'function('.$parameters.") { ".$closure." }";
		}
		
		return $argument;
	}
}