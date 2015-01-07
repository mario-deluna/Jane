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
 
use Jane\Scope\Variable;
 
class Compiler
{
	/**
	 * The parsed scope
	 *
	 * @var Jane\Scope 
	 */
	protected $scope = null;
	
	/**
	 * Create new compiler
	 *
	 * @param Jane\Scope 
	 */
	public function __construct( $scope )
	{
		$this->scope = $scope;
	}
	
	/**
	 * Transform the jane code and return the php code
	 *
	 * @return string
	 */
	public function transform()
	{
		$result = "";
		
		$nodes = $this->scope->getNodes();
		
		$declarations = array();
		
		// in php we can take all declarations to the top of the scope
		foreach( $nodes as $key => $node )
		{
			if ( $node instanceOf Node\VarDeclaration )
			{
				$declarations[] = $node; unset( $nodes[$key] );
			}
		}
		
		$result .= $this->compileVarDeclarations( $declarations );
		
		foreach( $nodes as $node )
		{
			$compilerFnc;
			
			if ( $node instanceOf Node )
			{
				$compilerFnc = $node->type;
			}
			else
			{
				$compilerFnc = explode( "\\", get_class( $node ) );
				$compilerFnc = array_pop( $compilerFnc );
			}
			
			$result .= call_user_func( array( $this, 'compile'.ucfirst( $compilerFnc ) ), $node );
		}
		
		return $result;
	}
	
	/**
	 * Converts an var object to string
	 *
	 * @param string 			$identifier
	 * @return string
	 */
	protected function varToString( Variable $var )
	{
		return '$'.$var->identifier();
	}
	
	/**
	 * Convert the jane assigner to a string
	 *
	 * @param string 			$assigner
	 * @return string
	 */
	protected function assignerToString( $assigner )
	{
		switch ( $assigner ) 
		{
			case 'equal':
				return '=';
			break;
			
			default:
				throw new Exception( "Uknown value assigner ".$assigner );
			break;
		}
	}
	
	/**
	 * Compiles the var declarations
	 *
	 * @param array[Jane\Node] 			$nodes
	 * @return string
	 */
	protected function compileVarDeclarations( array $nodes )
	{
		$buffer = "";
		
		foreach( $nodes as $node )
		{
			$buffer .= $this->varToString( $node->var ).', ';
		}
		
		return substr( $buffer, 0, -2 ).";\n\n";
	}
	
	/**
	 * Compiles the var assignment
	 *
	 * @param Jane\Node 			$node
	 * @return string
	 */
	protected function compileVarAssignment( $node )
	{
		return $this->varToString( $node->var ).' '.$this->assignerToString( $node->assigner ).' '.reset( $node->value )->value.";\n";
	}
	
	/**
	 * Compiles the var assignment
	 *
	 * @param Jane\Node 			$node
	 * @return string
	 */
	protected function compileLinebreak( $node )
	{
		return "\n";
	}
}