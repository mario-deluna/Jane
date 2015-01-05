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
	
	/**
	 * Test for single var declarations
	 *
	 * @param string 			$jane 			The jane code
	 * @param string 			$identifier		The name of the variable
	 * @param string 			$dataType		The dataType of the var
	 */
	public function singleVarDeclarationWithType( $jane, $identifier, $dataType )
	{
		// single assignment
		$scope = Jane::parse( $jane );
		$this->assertInstanceOf( 'Jane\\Scope', $scope );
		
		list( $declaration ) = $scope->getNodes();
		
		// check if we got the declaration
		$this->assertInstanceOf( 'Jane\\Node\\varDeclaration', $declaration );
		
		// the scope should contain one var
		$this->assertEquals( 1, count( $vars = $scope->getVars() ) );
		
		// check if the var isset
		$this->assertTrue( isset( $vars[$identifier] ) );
		
		if ( isset( $vars[$identifier] ) )
		{
			// check if the var type is undefined and the identifier is correct
			$this->assertEquals( $dataType, $vars[$identifier]->dataType() );
			$this->assertEquals( $identifier, $vars[$identifier]->identifier() );
			
			// check if the declaration var is the same as the scope
			$this->assertEquals( $vars[$identifier], $declaration->var );
		}
	}
	
	/**
	 * tests single var declaration 
	 */
	public function test_singleVarDeclarationWithTypeUndefined()
	{
		$this->singleVarDeclarationWithType( 'var foo', 'foo', null );
	}
	
	/**
	 * tests single int declaration 
	 */
	public function test_singleVarDeclarationWithTypeInt()
	{
		$this->singleVarDeclarationWithType( 'int number', 'number', 'primitiveInt' );
	}
	
	/**
	 * tests single float declaration 
	 */
	public function test_singleVarDeclarationWithTypeFloat()
	{
		$this->singleVarDeclarationWithType( 'float number', 'number', 'primitiveFloat' );
	}
	
	/**
	 * tests single double declaration 
	 */
	public function test_singleVarDeclarationWithTypeDouble()
	{
		$this->singleVarDeclarationWithType( 'double number', 'number', 'primitiveDouble' );
	}
	
	/**
	 * tests single string declaration 
	 */
	public function test_singleVarDeclarationWithTypeString()
	{
		$this->singleVarDeclarationWithType( 'string name', 'name', 'primitiveString' );
	}
	
	/**
	 * tests single bool declaration 
	 */
	public function test_singleVarDeclarationWithTypeBool()
	{
		$this->singleVarDeclarationWithType( 'bool active', 'active', 'primitiveBool' );
	}
	
	/**
	 * tests single bool declaration 
	 */
	public function test_singleVarDeclarationWithTypeArray()
	{
		$this->singleVarDeclarationWithType( 'array users', 'users', 'primitiveArray' );
	}
	
	/**
	 * tests Parser
	 */
	public function test_singleVarDeclarationWithTypeFloatasd()
	{			
		/*$scope = Jane::parse( '
		
		int index = 0, max = 5
		string name = "mario"
		float money = 1.5
		bool active = yes

		' );*/

		/*$scope = Jane::parse( '
		
		var foo, bar

		int index, min, max

		string name = "mario", default = "foo"

		float money = .5

		index = 1
		min = 1
		max = 5

		' );
		
		$this->assertInstanceOf( 'Jane\\Scope', $scope );
		
		
		//print_r( $scope ); die;
		
		$data = $parser->parse();
		
		$this->assertInstanceOf( 'Jane\\Node\\VarAssignment', $data );
		$this->assertEquals( 'myVar', $data->identifier );
		$this->assertEquals( '=', $data->assigner );
		$this->assertEquals( '"hello world"', $data->value );*/
	}
	
	/**
	 * tests Parser
	 */
	public function test_fncDefinition()
	{
		/*$lexer = new Lexer( 'fnc foo: a, b { a = b }' );
		$parser = new Parser( $lexer->tokens() );
		$data = $parser->parse(); //$data = $data[0];
		
		print_r( $data ); */
	}
}