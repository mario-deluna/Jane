<?php
/**
 * Jane Iterator tests
 ** 
 *
 * @package 		Jane
 * @author		Mario Döring <mario@clancats.com>
 * @version		1.0
 * @copyright 	2014 ClanCats GmbH
 *
 * @group Jane
 * @group Jane_Iterator
 */
class Jane_Iterator_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * tests $iterator->next()
	 */
	public function test_next()
	{
		$iterator = new Jane_Iterator( "012345" );
		
		$i = 0;
		
		while( $iterator->next() )
		{
			$this->assertEquals( $i, $iterator->char() );
			
			// test last char
			if ( $i > 0 )
			{
				$this->assertEquals( $i-1, $iterator->last_char() ); 
			}
			
			// test next char
			if ( $i < 5 )
			{
				$this->assertEquals( $i+1, $iterator->next_char() ); 
			}
			
			$i++;
		}
		
		$this->assertEquals( 6, $i );
	}
	
	/**
	 * tests $iterator->in_string()
	 */
	public function test_in_string()
	{
		// single quotes
		$iterator = new Jane_Iterator( "'B'" );
		
		$i = 0;
		
		while( $iterator->next() )
		{
			if ( $iterator->char() === 'B' )
			{
				$this->assertTrue( $iterator->in_string() );
			}
			
			$i++;
		}
		
		// double quotes
		$iterator = new Jane_Iterator( '"B"' );
		
		$i = 0;
		
		while( $iterator->next() )
		{
			if ( $iterator->char() === 'B' )
			{
				$this->assertTrue( $iterator->in_string() );
			}
			
			$i++;
		}
		
		// no quotes
		$iterator = new Jane_Iterator( 'B' );
		
		$i = 0;
		
		while( $iterator->next() )
		{
			if ( $iterator->char() === 'B' )
			{
				$this->assertFalse( $iterator->in_string() );
			}
			
			$i++;
		}
	}
}