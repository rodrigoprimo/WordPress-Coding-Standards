<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\EscapingFunctionsTrait;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\EscapingFunctionsTrait;

/**
 * Tests for the `EscapingFunctionsTrait::is_auto_escaped_function()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\EscapingFunctionsTrait::is_auto_escaped_function()
 */
final class IsAutoEscapedFunctionUnitTest extends TestCase {

	/**
	 * Test class using the EscapingFunctionsTrait for testing purposes.
	 *
	 * @var object
	 */
	private static $testClass;

	/**
	 * Set up the test class.
	 *
	 * @beforeClass
	 *
	 * @return void
	 */
	public static function setUpBeforeClass(): void {
		self::$testClass = new class() {
			use EscapingFunctionsTrait;
		};
	}

	/**
	 * Test is_auto_escaped_function().
	 *
	 * @dataProvider dataIsAutoEscapedFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsAutoEscapedFunction( $functionName, $expectedResult ) {
		$result = self::$testClass->is_auto_escaped_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsAutoEscapedFunction()
	 */
	public static function dataIsAutoEscapedFunction() {
		return array(
			'bloginfo'            => array(
				'functionName'   => 'bloginfo',
				'expectedResult' => true,
			),
			'bloginfo_uppercase'  => array(
				'functionName'   => 'BLOGINFO',
				'expectedResult' => true,
			),
			'fq_bloginfo'         => array(
				'functionName'   => '\bloginfo',
				'expectedResult' => true,
			),
			'esc_html'            => array(
				'functionName'   => 'esc_html',
				'expectedResult' => false,
			),
			'partially_qualified' => array(
				'functionName'   => 'MyNamespace\bloginfo',
				'expectedResult' => false,
			),
			'fq_namespaced'       => array(
				'functionName'   => '\MyNamespace\bloginfo',
				'expectedResult' => false,
			),
			'namespace_relative'  => array(
				'functionName'   => 'namespace\bloginfo',
				'expectedResult' => false,
			),
		);
	}
}
