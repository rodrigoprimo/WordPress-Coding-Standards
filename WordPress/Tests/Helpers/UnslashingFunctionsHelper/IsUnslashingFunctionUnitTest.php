<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\UnslashingFunctionsHelper;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\UnslashingFunctionsHelper;

/**
 * Tests for the `UnslashingFunctionsHelper::is_unslashing_function()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\UnslashingFunctionsHelper::is_unslashing_function()
 */
final class IsUnslashingFunctionUnitTest extends TestCase {

	/**
	 * Test is_unslashing_function().
	 *
	 * @dataProvider dataIsUnslashingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsUnslashingFunction( $functionName, $expectedResult ) {
		$result = UnslashingFunctionsHelper::is_unslashing_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsUnslashingFunction()
	 */
	public static function dataIsUnslashingFunction() {
		return array(
			'wp_unslash'           => array(
				'functionName'   => 'wp_unslash',
				'expectedResult' => true,
			),
			'wp_unslash_uppercase' => array(
				'functionName'   => 'WP_UNSLASH',
				'expectedResult' => true,
			),
			'fq_wp_unslash'        => array(
				'functionName'   => '\wp_unslash',
				'expectedResult' => true,
			),
			'stripslashes'         => array(
				'functionName'   => 'stripslashes',
				'expectedResult' => false,
			),
			'partially_qualified'  => array(
				'functionName'   => 'MyNamespace\wp_unslash',
				'expectedResult' => false,
			),
			'fq_namespaced'        => array(
				'functionName'   => '\MyNamespace\wp_unslash',
				'expectedResult' => false,
			),
			'namespace_relative'   => array(
				'functionName'   => 'namespace\wp_unslash',
				'expectedResult' => false,
			),
		);
	}
}
