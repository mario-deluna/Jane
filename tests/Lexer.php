<?php namespace Jane\Tests;
/**
 * Jane Iterator tests
 ** 
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Jane
 */

use Jane\Lexer;

class Lexer_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * tests Lexer
	 */
	public function test_consturct()
	{	
		$lexer = new Lexer( 'foo' );
		
		$this->assertInstanceOf( 'Jane\\Lexer', $lexer );
		$this->assertEquals( 3, $lexer->length() );
	}
	
	/**
	 * tests Lexer
	 */
	public function test_tokenString()
	{	
		// assign an of an string
		$lexer = new Lexer( '"hello world"' );
		
		// assign an of an string singlequotes
		$lexer = new Lexer( "'hello world'" );
		
		// assign an of an string singlequotes escaped
		$lexer = new Lexer( "'hello \'world'" );
		 
		var_dump( $lexer->getTokens() );
	}
}