<?php
/**
 * Jane Configuration
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
class Jane_Config
{
	/**
	 * Configuration data
	 *
	 * @var array
	 */
	protected $data = array();
	
	/** 
	 * Create new configuration
	 *
	 * @param array 		$data
	 * @return void
	 */
	public function __construct( array $data )
	{
		$this->data = $data;
	}
	
	/**
	 * Get configuration data
	 *
	 * @param string 		$key
	 * @return mixed
	 */ 
	public function get( $key )
	{
		return $this->data[$key];
	}
}