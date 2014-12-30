<?php namespace Jane\Node;
/**
 * Jane Node Var Assignment
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 */
class VarAssignment implements NodeInterface
{
	/**
	 * The Var identifier
	 *
	 * @var string
	 */
	public $identifier = null;
	
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
	public function __construct( $identifier, $assigner, $value )
	{
		$this->identifier = $identifier;
		$this->assigner = $assigner;
		$this->value = $value;	
	}
}