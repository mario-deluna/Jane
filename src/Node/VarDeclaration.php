<?php namespace Jane\Node;
/**
 * Jane Node Var Assignment
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */
class VarDeclaration implements NodeInterface
{
	/**
	 * Returns the name of the compiler function
	 *
	 * @return string
	 */
	public function compiler()
	{
		return "VarDeclaration";
	}
	
	/**
	 * The Var identifier
	 *
	 * @var Jane\Scope\Var
	 */
	public $var = null;
	
	/**
	 * Var assignment constructor
	 *
	 * @param string 		$identifier
	 * @param string 		$assigner
	 * @param string 		$value
	 *
	 * @return void
	 */
	public function __construct( $var )
	{
		$this->var = $var;
	}
}