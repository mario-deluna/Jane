<?php
/**
 * Jane Function compiler tests
 ** 
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Compiler_Function
 */
class Jane_Compiler_Function_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Get the compiler
	 */
	public function compiler( $code )
	{
		return new Jane_Compiler_Function( $code );
	}
	
	/**
	 * tests basic transformations
	 */
	public function test_compile()
	{
		$result = $this->compiler( '[print]' );
		
		$this->assertEquals( 'print()', $result->compile() );
		
		// double point in string
		$result = $this->compiler( '[print: ":foo"]' );
		
		$this->assertEquals( 'print( ":foo" )', $result->compile() );
		
		// more parameters
		$result = $this->compiler( '[substr: "jeff", 2, -1 ]' );
		
		$this->assertEquals( 'substr( "jeff", 2, -1 )', $result->compile() );
		
		// static call
		$result = $this->compiler( '[User remove:12]' );
		
		$this->assertEquals( 'User::remove( 12 )', $result->compile() );
		
		// instance call
		$result = $this->compiler( '[$user save]' );
		
		$this->assertEquals( '$user->save()', $result->compile() );
		
		// some spaces
		$result = $this->compiler( '[  $user save  ]' );
		
		$this->assertEquals( '$user->save()', $result->compile() );
		
		// instance dimensions call
		$result = $this->compiler( '[$user->profile save]' );
		
		$this->assertEquals( '$user->profile->save()', $result->compile() );
		
		// function in function
		$result = $this->compiler( '[substr: [User change_name:[NameGenerator create: 6, 12]], 2, -1 ]' );
		
		$this->assertEquals( 'substr( User::change_name( NameGenerator::create( 6, 12 ) ), 2, -1 )', $result->compile() );
	}
}