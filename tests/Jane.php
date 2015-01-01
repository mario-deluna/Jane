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
 * @group Jane_Jane
 */

use Jane\Jane;

class Jane_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * tests Jane::config
	 */
	public function test_config()
	{	
		$this->assertInstanceOf( 'Jane\\Config', Jane::config() );
		$this->assertEquals( '1.0', Jane::config( 'version' ) );
	}
	
	/**
	 * tests Jane::configure
	 */
	public function test_configure()
	{
		$version = Jane::config( 'version' );
		
		Jane::configure( array( 'version' => 'test', 'foo' => 'bar' ) );
		
		$this->assertEquals( 'test', Jane::config( 'version' ) );
		$this->assertEquals( 'bar', Jane::config( 'foo' ) );
		
		Jane::configure( array( 'version' => $version ) );
		
		$this->assertEquals( $version, Jane::config( 'version' ) );
		$this->assertEquals( 'bar', Jane::config( 'foo' ) );
	}
}