<?php namespace Jane\Node;
/**
 * Jane Node Interface
 **
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 */
 

interface NodeInterface
{
	/**
	 * Returns the name of the compiler function
	 *
	 * @return string
	 */
	public function compiler();
}