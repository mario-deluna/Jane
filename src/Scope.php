<?php namespace Jane;
/**
 * Jane Scope Object
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 */
 
use Jane\Scope\Var;
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
	 * Adds a var to the current scope
	 *
	 * @param mixed...
	 * @return void
	 */
	public function addVar()
	{
		$args = func_get_args();
		
		if ( count( $args ) > 1 )
		{
			if ( !isset( $args[0] ) )
			{
				throw new Exception( 'No name given for var.' );
			}
			
			$name = $args[0];
			$dataType = null;
			
			// data type
			if ( isset( $args[1] ) )
			{
				$dataType = $args[1];
			}
			
			// create and add the new var
			$this->variables[ $name ] = new Var( $name, $dataType );
		}
		else
		{
			if ( ! ( $args[0] instanceof Var ) )
			{
				throw new Exception( 'Invalid var object assigned to scope.' );
			}
			
			// add the var
			$this->variables[$args[0]->name] = $args[0];
		}
	}
}