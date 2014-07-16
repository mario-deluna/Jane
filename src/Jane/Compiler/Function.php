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
	 * return the compiled code
	 *
	 * @return string
	 */
	public function compile()
	{
		// I hate this workaround
		$that = $this;
		
		return preg_replace_callback('/\[(.*?)\]/s', function( $match ) use( $that )
		{ 
			$function = $match[1];
			
			list( $function, $arguments ) = explode( ':', $function );
			
			return $function.'( '.$arguments.' )';
		}, $this->code );
	}
}