<?php namespace Jane;
/**
 * Jane Scope Object
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */
 
use Jane\Scope\Variable;
use Jane\Exception;
 
class Scope
{	
	/**
	 * The variables in the curren scope
	 * 
	 * @var array
	 */
	protected $variables = array();
	
	/**
	 * The code items in this scope
	 * 
	 * @var array
	 */
	protected $nodes = array();
	
	/**
	 * Return all nodes
	 *
	 * @return array
	 */
	public function getNodes()
	{
		return $this->nodes;
	}
	
	/**
	 * Adds a new node to the current scope
	 * By passing an array every item gets added on its own.
	 *
	 * @param Jane\Node|array 			$nodes
	 * @return void
	 */
	public function addNode( $nodes )
	{
		if ( !is_array( $nodes ) )
		{
			$nodes = array( $nodes );
		}

		foreach( $nodes as $node )
		{
			$this->nodes[] = $node;
		}
	}
	
	/**
	 * Recive the vars in this scope
	 *
	 * @return array[Var]
	 */
	public function getVars()
	{
		return $this->variables;
	}

	/**
	 * Check if the var already exists in scope
	 */
	public function hasVar( $identifier )
	{
		return isset( $this->variables[ $identifier ] );
	}

	/**
	 * Get a var object
	 *
	 * @param string 			$identifier
	 * @return array[Var]
	 */
	public function getVar( $identifier )
	{
		return $this->variables[ $identifier ];
	}
	
	/**
	 * Adds a var to the current scope
	 *
	 * @param mixed...
	 * @return Jane\Scope\Var
	 */
	public function addVar()
	{
		$args = func_get_args();
		
		if ( !isset( $args[0] ) )
		{
			throw new Exception( 'No name given for var.' );
		}
		
		$var = null;
		
		if ( !is_object( $args[0] ) )
		{
			$name = $args[0];
			$dataType = null;
			
			// data type
			if ( isset( $args[1] ) )
			{
				$dataType = $args[1];
			}
			
			// create and add the new var
			$var = $this->variables[ $name ] = new Variable( $name, $dataType );
		}
		else
		{
			if ( ! ( $args[0] instanceof Variable ) )
			{
				throw new Exception( 'Invalid var object assigned to scope.' );
			}
			
			// add the var
			$var = $this->variables[$args[0]->name] = $args[0];
		}
		
		return $var;
	}
}