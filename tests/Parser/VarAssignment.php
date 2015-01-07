<?php namespace Jane\Tests;
/**
 * Jane Parser tests
 ** 
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Parser
 * @group Jane_Parser_VarDeclaration
 */

use Jane\Jane;
use Jane\Parser;
use Jane\Lexer;

class Parser_VarAssignment_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * tests single var declaration 
	 */
	public function test_singleVarDeclarationWithTypeUndefined()
	{
		//$this->singleVarDeclarationWithType( 'var foo = "bar"', 'foo', 'equal', '"bar"', null );
	}
}