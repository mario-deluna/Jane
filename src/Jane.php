<?php 
/**
 * Jane main
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
class Jane 
{	
	/**
	 * Run the jane transormer over a piece of code
	 *
	 * @param string			$code
	 * @return string
	 */
	public static function transform( $code )
	{
		return static::create( $code )->transform(); 
	}
	
	/**
	 * Creat new Jane compiler
	 *
	 * @param string 		$code
	 * @return Jane_Compiler
	 */
	public static function create( $code = null )
	{
		return new Jane_Compiler( $code );
	}
}