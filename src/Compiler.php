<?php
/**
 * Jane Compiler
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
class Jane_Compiler
{
	/**
	 * The transormed code
	 *
	 * @var string
	 */
	protected $code = "";
	
	/**
	 * The original code
	 *
	 * @var string
	 */
	protected $original = "";
	
	/**
	 * The code compilers
	 *
	 * @var array
	 */
	protected $compilers = array(
		// 'vars', // we do not compile vars at the moment because well its freking tricky
		'function',
	);
	
	/**
	 * Create new compiler
	 *
	 * @param string 
	 */
	public function __construct( $code = null )
	{
		if ( !is_null( $code ) )
		{
			$this->code( $code );
		}
	}
	
	/**
	 * Set the code
	 *
	 * @param string 		$code
	 * @return void
	 */
	public function code( $code )
	{
		$this->code = $this->original = $code;
	}
	
	/**
	 * Transform the jane code and return the php code
	 *
	 * @return string
	 */
	public function transform()
	{
		$this->code = $this->original;
		
		foreach( $this->compilers as $compiler )
		{
			$compiler = 'Jane_Compiler_'.ucfirst( $compiler );
			$compiler = new $compiler( $this->code );
			$this->code = $compiler->compile();
		}
		
		return $this->code;
	}
}