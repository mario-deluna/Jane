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
}