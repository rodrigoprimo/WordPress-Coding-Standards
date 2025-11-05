<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\SanitizationHelperTrait;

use WordPressCS\WordPress\Helpers\SanitizationHelperTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the `SanitizationHelperTrait::is_sanitizing_and_unslashing_function()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\SanitizationHelperTrait::is_sanitizing_and_unslashing_function()
 */
final class IsSanitizingAndUnslashingFunctionUnitTest extends TestCase {

	/**
	 * Test class using the SanitizationHelperTrait for testing purposes.
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
			use SanitizationHelperTrait;
		};
	}

	/**
	 * Test is_sanitizing_and_unslashing_function().
	 *
	 * @dataProvider dataIsSanitizingAndUnslashingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsSanitizingAndUnslashingFunction( $functionName, $expectedResult ) {
		$result = self::$testClass->is_sanitizing_and_unslashing_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsSanitizingAndUnslashingFunction()
	 */
	public static function dataIsSanitizingAndUnslashingFunction() {
		return array(
			'absint'              => array(
				'functionName'   => 'absint',
				'expectedResult' => true,
			),
			'intval_mixed_case'   => array(
				'functionName'   => 'IntVal',
				'expectedResult' => true,
			),
			'fq_absint'           => array(
				'functionName'   => '\absint',
				'expectedResult' => true,
			),
			'sanitize_text_field' => array(
				'functionName'   => 'sanitize_text_field',
				'expectedResult' => false,
			),
			'partially_qualified' => array(
				'functionName'   => 'MyNamespace\absint',
				'expectedResult' => false,
			),
			'fq_namespaced'       => array(
				'functionName'   => '\MyNamespace\absint',
				'expectedResult' => false,
			),
			'namespace_relative'  => array(
				'functionName'   => 'namespace\absint',
				'expectedResult' => false,
			),
		);
	}
}
