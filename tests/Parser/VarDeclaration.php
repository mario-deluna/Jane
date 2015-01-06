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

class Parser_VarDeclaration_Test extends \PHPUnit_Framework_TestCase
{
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
	 * tests wrong single declaration 
	 *
	 * @expectedException Jane\Parser\Exception
	 */
	public function test_invalidSingleVarDeclarationWithTypeUndefined()
	{
		Jane::parse( 'var var foo' );
	}


	/**
	 * Test for multiple var declarations
	 *
	 * @param string 			$jane 			The jane code
	 * @param array 			$identifier		Array of expected variable names
	 * @param string 			$dataType		The dataType of the var
	 */
	public function multipleVarDeclarationWithType( $jane, $identifier, $dataType )
	{
		// single assignment
		$scope = Jane::parse( $jane );
		$this->assertInstanceOf( 'Jane\\Scope', $scope );

		// the scope should contain one var
		$this->assertEquals( count( $identifier ), count( $vars = $scope->getVars() ) );

		$nodes = $scope->getNodes();

		// check every identifier
		foreach( $identifier as $key => $name )
		{
			$node = $nodes[$key];

			// check if we got the declaration
			$this->assertInstanceOf( 'Jane\\Node\\varDeclaration', $node );

			// check if the var isset
			$this->assertTrue( isset( $vars[$name] ) );

			if ( isset( $vars[$name] ) )
			{
				// check if the var type is undefined and the identifier is correct
				$this->assertEquals( $dataType, $vars[$name]->dataType() );
				$this->assertEquals( $name, $vars[$name]->identifier() );

				// check if the declaration var is the same as the scope
				$this->assertEquals( $vars[$name], $node->var );
			}
		}
	}

	/**
	 * tests multiple var declaration 
	 */
	public function test_multipleVarDeclarationWithTypeUndefined()
	{
		$this->multipleVarDeclarationWithType( 'var jane, jenny, johanna, johnny', array( 'jane', 'jenny', 'johanna', 'johnny' ), null );
	}

	/**
	 * tests single int declaration 
	 */
	public function test_multipleVarDeclarationWithTypeInt()
	{
		$this->multipleVarDeclarationWithType( 'int number1, number2', array( 'number1', 'number2' ), 'primitiveInt' );
	}

	/**
	 * tests single float declaration 
	 */
	public function test_multipleVarDeclarationWithTypeFloat()
	{
		$this->multipleVarDeclarationWithType( 'float number1, number2', array( 'number1', 'number2' ), 'primitiveFloat' );
	}

	/**
	 * tests single double declaration 
	 */
	public function test_multipleVarDeclarationWithTypeDouble()
	{
		$this->multipleVarDeclarationWithType( 'double number1, number2', array( 'number1', 'number2' ), 'primitiveDouble' );
	}

	/**
	 * tests single string declaration 
	 */
	public function test_multipleVarDeclarationWithTypeString()
	{
		$this->multipleVarDeclarationWithType( 'string name1, name2, name3', array( 'name1', 'name2', 'name3' ), 'primitiveString' );
	}

	/**
	 * tests single bool declaration 
	 */
	public function test_multipleVarDeclarationWithTypeBool()
	{
		$this->multipleVarDeclarationWithType( 'bool active, hidden', array( 'active', 'hidden' ), 'primitiveBool' );
	}

	/**
	 * tests single bool declaration 
	 */
	public function test_multipleVarDeclarationWithTypeArray()
	{
		$this->multipleVarDeclarationWithType( 'array users, groups', array( 'users', 'groups' ), 'primitiveArray' );
	}

	/**
	 * tests wrong single declaration 
	 *
	 * @expectedException Jane\Parser\Exception
	 */
	public function test_invalidMultipleVarDeclarationWithTypeUndefined()
	{
		Jane::parse( 'var users, group,,' );
	}
}