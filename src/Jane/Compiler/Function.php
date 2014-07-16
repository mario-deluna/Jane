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
	public function transform_functions()
	{
		// I hate this workaround
		$that = $this;
		
		$this->code =  preg_replace_callback('/\[(.*?)\]/s', function( $match ) use( $that )
		{ 
			$function = trim( $match[1] );
			
			if ( strpos( $function, ':' ) !== false )
			{
				$arguments = substr( $function, strpos( $function, ':' )+1 );
				$arguments = trim( $arguments );	
				
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
		}, $this->code );
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