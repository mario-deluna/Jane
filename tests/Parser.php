<?php namespace Jane\Tests;
/**
 * Jane Parser tests
 ** 
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Parser
 */

use Jane\Parser;

class Parser_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * tests Parser
	 */
	public function test_consturct()
	{	
		$parser = new Parser( 'foo' );
		
		$this->assertInstanceOf( 'Jane\\Parser', $parser );
	}
	
	/**
	 * tests Parser
	 */
	public function test_varAssignment()
	{	
		// string
		$parser = new Parser( 'myVar = "hello world"' );
		
		$parser = new Parser( 'myVar, myOtherVar, AndAnotherVar = "hello world"' );
		var_dump( $parser->parse() );
	}
}