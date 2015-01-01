<?php namespace Jane;
/**
 * Jane Compiler
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */
class Compiler
{
	/**
	 * The parsed code
	 *
	 * @var array[Jane\Node]
	 */
	protected $code = array();
	
	/**
	 * Create new compiler
	 *
	 * @param string 
	 */
	public function __construct( array $code )
	{
		$this->code = $code;
	}
	
	/**
	 * Transform the jane code and return the php code
	 *
	 * @return string
	 */
	public function transform()
	{
		$result = "";
		
		foreach( $this->code as $node )
		{
			$result .= call_user_func( array( $this, 'compile'.ucfirst( $node->compiler() ) ), $node );
		}
		
		return $result;
	}
	
	/**
	 * Converts an identifier to an var
	 *
	 * @param string 			$identifier
	 * @return string
	 */
	protected function identifierToVar( $identifier )
	{
		return '$'.$identifier;
	}
	
	/**
	 * Compiles the var assignment
	 *
	 * @param Jane\Node 			$node
	 * @return string
	 */
	protected function compileVarAssignment( $node )
	{
		return $this->identifierToVar( $node->identifier ).' '.$node->assigner.' '.$node->value.";\n";
	}
}