<?php
/**
 * Jane  Compiler Interface
 **
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 */
interface Jane_Compiler_Interface
{
	/**
	 * return the compiled code
	 *
	 * @return string
	 */
	public function compile();
}