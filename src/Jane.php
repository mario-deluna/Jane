<?php namespace Jane;
/**
 * Jane main
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
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
		
		// the current jane version. If updated don't forget to
		// also update the Jane\Tests\Jane config test.
		'version' => '1.0',
		
		// how many function can a function maximal contain.
		'function_call_depth' => 8,
	);
	
	/**
	 * Configure the Jane settings
	 * 
	 * @param array 		$config
	 */
	public static function configure( $config = array() )
	{
		if ( is_null( static::$config ) )
		{
			$defaults = static::$default_config;
		}
		else
		{
			$defaults = static::$config->get_all();
		}
		
		static::$config = new Config( array_merge( $defaults, $config ) );
	}
	
	/**
	 * Get a jane configuration value
	 *
	 * @param string 		$key
	 * @return mixed
	 */
	public static function config( $key = null )
	{
		// if the configuration has not been loaded yet do it.
		if ( is_null( static::$config ) )
		{
			static::configure();
		}
		
		// if there is no key return the entire config object
		if ( is_null( $key ) )
		{
			return static::$config;
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