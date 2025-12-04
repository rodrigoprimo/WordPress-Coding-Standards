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
 * Tests for the `EscapingFunctionsTrait::is_escaping_function()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\EscapingFunctionsTrait::is_escaping_function()
 */
final class IsEscapingFunctionUnitTest extends TestCase {

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
	 * Test is_escaping_function().
	 *
	 * @dataProvider dataIsEscapingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsEscapingFunction( $functionName, $expectedResult ) {
		$result = self::$testClass->is_escaping_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsEscapingFunction()
	 */
	public static function dataIsEscapingFunction() {
		return array(
			'esc_html'            => array(
				'functionName'   => 'esc_html',
				'expectedResult' => true,
			),
			'esc_html_uppercase'  => array(
				'functionName'   => 'ESC_HTML',
				'expectedResult' => true,
			),
			'fq_esc_html'         => array(
				'functionName'   => '\esc_html',
				'expectedResult' => true,
			),
			'printf'              => array(
				'functionName'   => 'printf',
				'expectedResult' => false,
			),
			'partially_qualified' => array(
				'functionName'   => 'MyNamespace\esc_html',
				'expectedResult' => false,
			),
			'fq_namespaced'       => array(
				'functionName'   => '\MyNamespace\esc_html',
				'expectedResult' => false,
			),
			'namespace_relative'  => array(
				'functionName'   => 'namespace\esc_html',
				'expectedResult' => false,
			),
		);
	}
}
