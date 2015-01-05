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
class VarAssignment implements NodeInterface
{	
	/**
	 * The Var identifier
	 *
	 * @var Jane\Scope\Var
	 */
	public $var = null;
	
	/**
	 * The var assigner ( =, +=, -= etc. )
	 *
	 * @var string
	 */
	public $assigner = null;
	
	/**
	 * The var value
	 * 
	 * @var string
	 */
	public $value = null;
	
	/**
	 * Var assignment constructor
	 *
	 * @param string 		$identifier
	 * @param string 		$assigner
	 * @param string 		$value
	 *
	 * @return void
	 */
	public function __construct( $var, $assigner, $value )
	{
		$this->var = $var;
		$this->assigner = $assigner;
		$this->value = $value;	
	}
}