<?php namespace Jane;
/**
 * Jane Base Parser
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */

class Node
{
	/**
	 * The token type 
	 *
	 * @var string
	 */
	public $type = null;
	
	/**
	 * The token type 
	 *
	 * @var string
	 */
	public $value = null;
	
	/**
	 * The token type 
	 *
	 * @var string
	 */
	public $line = null;
	 
	/**
	 * construct a new token node object
	 *
	 * @param array 		$token	The lexer token array
	 */
	public function __construct( array $token )
	{
		list( $this->type, $this->value, $this->line ) = $token;
	}
	
	/**
	 * Check if this is an assign node like equal
	 *
	 * @return bool
	 */
	public function isAssignNode()
	{
		return 
			$this->type === 'equal' || 
			$this->type === 'equalAdd' ||
			$this->type === 'equalSub' ||
			$this->type === 'equalMultiply' ||
			$this->type === 'equalDivide' ||
			$this->type === 'equalAppend';
	}
	
	/**
	 * Check if this is an assign node like equal
	 *
	 * @return bool
	 */
	public function isPrimitiveDefinition()
	{
		return 
			$this->type === 'primitiveInt' || 
			$this->type === 'primitiveFloat' ||
			$this->type === 'primitiveDouble' ||
			$this->type === 'primitiveString' ||
			$this->type === 'primitiveArray' ||
			$this->type === 'primitiveBool';
	}
	
	/**
	 * Check if this is an assign node like equal
	 *
	 * @return bool
	 */
	public function isAssignableValue()
	{
		return 
			$this->type === 'identifier' || 
			$this->type === 'string';
	}

	/**
	 * Check if this is an assign node like equal
	 *
	 * @return bool
	 */
	public function isBool()
	{
		return 
			$this->type === 'boolTrue' || 
			$this->type === 'boolFalse';
	}
}