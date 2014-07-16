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
	 * Jane configuration
	 *
	 * @var Jane_Config
	 */
	private static $config = null;
	
	/**
	 * Jane configuration
	 *
	 * @var Jane_Config
	 */
	private static $default_config = array(
		
		// how many function can a function maximal contain.
		'function_call_depth' => 8,
	);
	
	/**
	 * Get a jane configuration value
	 *
	 * @param string 		$key
	 * @return mixed
	 */
	public static function config( $key )
	{
		if ( is_null( static::$config ) )
		{
			static::$config = new Jane_Config( static::$default_config );
		}
		
		return static::$config->get( $key );
	}
	
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