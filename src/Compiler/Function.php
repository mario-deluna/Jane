<?php
/**
 * Jane Function Compiler
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
class Jane_Compiler_Function extends Jane_Compiler_Base implements Jane_Compiler_Interface
{
	/**
	 * Run the function transformer on the code
	 *
	 * @return void
	 */
	protected function transform_functions()
	{
		$buffer = "";
		
		$match = "";
		
		$function_depth = 0;
		
		for( $i=0;$i<strlen($this->code);$i++ )
		{
			$char = $this->code[$i];
			
			if ( $char === '[' )
			{
				$function_depth++;
			}
			
			if ( $function_depth > 0 )
			{
				$match .= $char;
			}
			else
			{
				$buffer .= $char;
			}
			
			if ( $char === ']' )
			{
				$function_depth--;
			}
			
			if ( $char === ']' && $function_depth === 0 )
			{
				$match = substr( $match, 1, -1 );
				$buffer .= $this->format_function( $match ); $match = '';
			}
		}
		
		$this->code = $buffer;
	}
	
	/**
	 * Function formatter
	 *
	 * @param string 	$function
	 * @return string
	 */
	protected function format_function( $function )
	{
		$function = trim( $function );
		
		if ( strpos( $function, ':' ) !== false )
		{
			$arguments = $this->parse_arguments( substr( $function, strpos( $function, ':' )+1 ) );
			$function = substr( $function, 0, strpos( $function, ':' ) );
		}
		else
		{
			$arguments = '';
		}
		
		// static call or instance call
		if ( strpos( $function, ' ' ) !== false )
		{
			// object context
			if ( substr( $function, 0, 1 ) === '$' )
			{
				$function = str_replace( ' ', '->', $function );
			}
			// staic context
			else
			{
				$function = str_replace( ' ', '::', $function );
			}
		}
		
		return $function.'('. ( strlen( $arguments ) > 0 ? ' '.$arguments.' ' : '' ) .')';
	}
	
	/**
	 * return the compiled code
	 *
	 * @return string
	 */
	public function compile()
	{
		for( $i=0;$i<Jane::config( 'function_call_depth' );$i++ )
		{
			$this->transform_functions();
		}
		
		return $this->code;
	}
}