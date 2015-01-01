<?php namespace Jane\Tests;
/**
 * Jane Iterator tests
 ** 
 *
 * @package 		Jane
 * @author			Mario Döring <mario@clancats.com>
 * @version			1.0
 * @copyright 		2014 - 2015 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Lexer
 */

use Jane\Lexer;

class Lexer_Test extends \PHPUnit_Framework_TestCase
{
	protected function pickTokenTypes( array $tokens )
	{
		$types = array();
		
		foreach( $tokens as $token )
		{
			$types[] = $token[0];
		}
		
		return $types;
	}
	
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
		// string
		$lexer = new Lexer( '"hello world"' );
		$this->assertEquals( ['string'], $this->pickTokenTypes( $lexer->tokens() ) );
		
		// string singlequotes
		$lexer = new Lexer( "'hello world'" );
		$this->assertEquals( ['string'], $this->pickTokenTypes( $lexer->tokens() ) );
		
		// string singlequotes escaped
		$lexer = new Lexer( "'hello \'world'" );
		$this->assertEquals( ['string'], $this->pickTokenTypes( $lexer->tokens() ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function test_tokenPrimitivesDeclaration()
	{	
		// int declaration
		$lexer = new Lexer( 'int myInt' );
		$this->assertEquals( 
			['primitiveInt', 'whitespace', 'identifier'], 
			$this->pickTokenTypes( $lexer->tokens() )
		);
		
		// float declaration
		$lexer = new Lexer( 'float myFloat' );
		$this->assertEquals( 
			['primitiveFloat', 'whitespace', 'identifier'], 
			$this->pickTokenTypes( $lexer->tokens() )
		);
		
		// float declaration
		$lexer = new Lexer( 'double myDouble' );
		$this->assertEquals( 
			['primitiveDouble', 'whitespace', 'identifier'], 
			$this->pickTokenTypes( $lexer->tokens() )
		);
		
		// bool declaration
		$lexer = new Lexer( 'bool myBool' );
		$this->assertEquals( 
			['primitiveBool', 'whitespace', 'identifier'], 
			$this->pickTokenTypes( $lexer->tokens() )
		);
		
		// bool declaration
		$lexer = new Lexer( 'string myString' );
		$this->assertEquals( 
			['primitiveString', 'whitespace', 'identifier'], 
			$this->pickTokenTypes( $lexer->tokens() )
		);
		
		// array declaration
		$lexer = new Lexer( 'array myArray' );
		$this->assertEquals( 
			['primitiveArray', 'whitespace', 'identifier'], 
			$this->pickTokenTypes( $lexer->tokens() )
		);
	}
}