<?php namespace Jane;
/**
 * Jane main
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
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

		// You can enbale the var overwrite. This might not work
		// in some languages but for php its safe.
		'allow_var_overwrite' => false,

		
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
			$defaults = static::$config->getAll();
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
	 * Parse jane code into an array
	 *
	 * @param string			$code
	 * @return string
	 */
	public static function parse( $code )
	{
		$lexer = new Lexer( $code );
		$parser = new Parser( $lexer->tokens() );
		
		return $parser->parse(); 
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
}