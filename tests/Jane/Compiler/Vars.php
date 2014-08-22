<?php
/**
 * Jane Var compiler tests
 ** 
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Compiler_Vars
 */
class Jane_Compiler_Vars_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Get the compiler
	 */
	public function compiler( $code )
	{
		return new Jane_Compiler_Vars( $code );
	}

	/**
	 * tests basic transformations
	 */
	public function test_compile()
	{
		$result = $this->compiler( 'result = 15 + 21' );

		$this->assertEquals( '$result = 15 + 21', $result->compile() );
		
		// inside an if argument
		$result = $this->compiler( 'if ( foo = "main" ) {}' );
		
		$this->assertEquals( 'if ( $foo = "main" ) {}', $result->compile() );
		
		// multiple var
		$result = $this->compiler( 'data = array( 1,2,3 ); string = implode( ",", data );' );
		
		$this->assertEquals( '$data = array( 1,2,3 ); $string = implode( ",", $data );', $result->compile() );
	}
}