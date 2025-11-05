<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\SanitizationHelperTrait;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\SanitizationHelperTrait;

/**
 * Tests for the `SanitizationHelperTrait::is_sanitizing_function()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\SanitizationHelperTrait::is_sanitizing_function()
 */
final class IsSanitizingFunctionUnitTest extends TestCase {

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
	 * Test is_sanitizing_function().
	 *
	 * @dataProvider dataIsSanitizingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsSanitizingFunction( $functionName, $expectedResult ) {
		$result = self::$testClass->is_sanitizing_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsSanitizingFunction()
	 */
	public static function dataIsSanitizingFunction() {
		return array(
			'sanitize_text_field'       => array(
				'functionName'   => 'sanitize_text_field',
				'expectedResult' => true,
			),
			'sanitize_email_mixed_case' => array(
				'functionName'   => 'Sanitize_Email',
				'expectedResult' => true,
			),
			'fq_sanitize_text_field'    => array(
				'functionName'   => '\sanitize_text_field',
				'expectedResult' => true,
			),
			'not_a_sanitizing_function' => array(
				'functionName'   => 'not_a_sanitizing_function',
				'expectedResult' => false,
			),
			'partially_qualified'       => array(
				'functionName'   => 'MyNamespace\sanitize_text_field',
				'expectedResult' => false,
			),
			'fq_namespaced'             => array(
				'functionName'   => '\MyNamespace\sanitize_text_field',
				'expectedResult' => false,
			),
			'namespace_relative'        => array(
				'functionName'   => 'namespace\sanitize_text_field',
				'expectedResult' => false,
			),
		);
	}
}
