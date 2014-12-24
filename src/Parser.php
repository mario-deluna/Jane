<?php
/**
 * Jane Base Parser
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 */
class Jane_Parser
{	
	/**
	 * The current scope
	 *
	 * @var Jane_Parser_Scope
	 */
	protected $scope = null;
	
	/**
	 * The constructor
	 *
	 * @var string 		$code
	 * @return void
	 */
	public function __construct( $code )
	{
		$this->scope = new Jane_Parser_Scope( $code );
	}	
	
	/**
	 * Return the current scope
	 *
	 * @return Jane_Parser_Scope
	 */
	public function scope()
	{
		return $this->scope;
	}
}