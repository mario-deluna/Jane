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
		$lexer = new Lexer( 'foo' );
		$parser = new Parser( $lexer->tokens() );
		
		$this->assertInstanceOf( 'Jane\\Parser', $parser );
	}
	
	/**
	 * test shortcut
	 */
	public function test_staticShortcut()
	{	
		//$result = Jane::parse( 'foo = "hello world"' );
		//$this->assertTrue( is_array( $result ) );
	}
	
	
	/**
	 * tests Parser
	 */
	public function test_varAssignment()
	{
		$lexer = new Lexer( 'myVar = "hello world"' );
		$parser = new Parser( $lexer->tokens() );
		var_dump( $parser->parse() ); die;
		
		$data = $parser->parse(); $data = $data[0];
		
		$this->assertInstanceOf( 'Jane\\Node\\VarAssignment', $data );
		$this->assertEquals( 'myVar', $data->identifier );
		$this->assertEquals( '=', $data->assigner );
		$this->assertEquals( '"hello world"', $data->value );
	}
	
	/**
	 * tests Parser
	 */
	public function test_fncDefinition()
	{
		$lexer = new Lexer( 'fnc foo: a, b { a = b }' );
		$parser = new Parser( $lexer->tokens() );
		$data = $parser->parse(); //$data = $data[0];
		
		print_r( $data ); 
	}
}