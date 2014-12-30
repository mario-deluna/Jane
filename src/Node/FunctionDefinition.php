<?php namespace Jane\Node;
/**
 * Jane Node Function Definition
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 */
class FunctionDefinition implements NodeInterface
{
	/**
	 * Returns the name of the compiler function
	 *
	 * @return string
	 */
	public function compiler()
	{
		return "varAssignment";
	}
	
	/**
	 * The return type
	 *
	 * @var string
	 */
	public $dataType = null;
	
	/**
	 * The function name
	 *
	 * @var string
	 */
	public $name = null;
	
	/**
	 * The arguments
	 * 
	 * @var array
	 */
	public $arguments = null;
	
	/**
	 * constructor
	 *
	 * @param string 		$returnType
	 * @param string 		$name
	 * @param string 		$arguments
	 *
	 * @return void
	 */
	public function __construct( $dataType, $name, $arguments )
	{
		$this->dataType = $dataType;
		$this->name = $name;
		$this->arguments = $arguments;	
	}
}