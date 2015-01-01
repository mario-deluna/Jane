<?php namespace Jane\Scope;
/**
 * Jane Scope Var
 **
 *
 * @package 		Jane
 * @author		    Mario Döring <mario@clancats.com>
 * @version	    	1.0   
 * @copyright 	    2014 - 2015 ClanCats GmbH
 *
 */
class Variable
{
	/**
	 * The var identifier
	 *
	 * @var array
	 */
	protected $identifier = null;
	
	/**
	 * The var data type
	 *
	 * @var array
	 */
	protected $dataType = null;
	
	/**
	 * Var constructor
	 *
	 * @param string           $identifier
	 * @param string           $dataType
	 *
	 * @return void
	 */
	public function __construct( $identifier, $dataType = null )
	{
    	$this->identifier = $identifier;
    	$this->dataType = $dataType;
	}
}