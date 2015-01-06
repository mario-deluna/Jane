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
 */

use Jane\Jane;
use Jane\Parser;
use Jane\Lexer;

class Parser_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * tests Parser
	 */
	public function test_consturct()
	{	
		$lexer = new Lexer( 'var foo' );
		$parser = new Parser( $lexer->tokens() );
		
		$this->assertInstanceOf( 'Jane\\Parser', $parser );
	}
	
	/**
	 * test parser shortcut
	 */
	public function test_staticShortcut()
	{	
		$scope = Jane::parse( 'var bar' );
		$this->assertInstanceOf( 'Jane\\Scope', $scope );
	}
}