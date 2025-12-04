<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\FormattingFunctionsHelper;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\FormattingFunctionsHelper;

/**
 * Tests for the `FormattingFunctionsHelper::is_formatting_function()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\FormattingFunctionsHelper::is_formatting_function()
 */
final class IsFormattingFunctionUnitTest extends TestCase {

	/**
	 * Test is_formatting_function().
	 *
	 * @dataProvider dataIsFormattingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsFormattingFunction( $functionName, $expectedResult ) {
		$result = FormattingFunctionsHelper::is_formatting_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsFormattingFunction()
	 */
	public static function dataIsFormattingFunction() {
		return array(
			'sprintf'             => array(
				'functionName'   => 'sprintf',
				'expectedResult' => true,
			),
			'sprintf_uppercase'   => array(
				'functionName'   => 'SPRINTF',
				'expectedResult' => true,
			),
			'fq_sprintf'          => array(
				'functionName'   => '\sprintf',
				'expectedResult' => true,
			),
			'printf'              => array(
				'functionName'   => 'printf',
				'expectedResult' => false,
			),
			'partially_qualified' => array(
				'functionName'   => 'MyNamespace\sprintf',
				'expectedResult' => false,
			),
			'fq_namespaced'       => array(
				'functionName'   => '\MyNamespace\sprintf',
				'expectedResult' => false,
			),
			'namespace_relative'  => array(
				'functionName'   => 'namespace\sprintf',
				'expectedResult' => false,
			),
		);
	}
}
