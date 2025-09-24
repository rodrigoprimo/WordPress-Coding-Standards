<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ContextHelper;

use WordPressCS\WordPress\Helpers\ContextHelper;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the `ContextHelper::is_in_isset_or_empty()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ContextHelper::is_in_isset_or_empty()
 */
final class IsInIssetOrEmptyUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_in_isset_or_empty().
	 *
	 * @dataProvider dataIsInIssetOrEmpty
	 *
	 * @param string     $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool       $expectedResult The expected return value.
	 * @param int|string $tokenType      Optional. The token type to search for.
	 *
	 * @return void
	 */
	public function testIsInIssetOrEmpty( $testMarker, $expectedResult, $tokenType = \T_VARIABLE ) {
		$stackPtr = $this->getTargetToken( $testMarker, $tokenType );
		$result   = ContextHelper::is_in_isset_or_empty( self::$phpcsFile, $stackPtr );

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|int>>
	 * @see testIsInIssetOrEmpty()
	 */
	public static function dataIsInIssetOrEmpty() {
		return array(
			'standalone_variable' => array(
				'testMarker'     => '/* testStandaloneVariable */',
				'expectedResult' => false,
			),
			'variable_assignment' => array(
				'testMarker'     => '/* testVariableAssignment */',
				'expectedResult' => false,
			),
			'other_function_call' => array(
				'testMarker'     => '/* testOtherFunctionCall */',
				'expectedResult' => false,
			),
			'array_key_exists_first_param' => array(
				'testMarker'     => '/* testArrayKeyExistsFirstParam */',
				'expectedResult' => false,
			),
			'key_exists_first_param' => array(
				'testMarker'     => '/* testKeyExistsFirstParam */',
				'expectedResult' => false,
			),
			'different_function_call' => array(
				'testMarker'     => '/* testDifferentFunctionCall */',
				'expectedResult' => false,
			),
			'nested_in_isset' => array(
				'testMarker'     => '/* testNestedInIsset */',
				'expectedResult' => false,
			),
			'nested_in_empty' => array(
				'testMarker'     => '/* testNestedInEmpty */',
				'expectedResult' => false,
			),
			'namespaced_array_key_exists' => array(
				'testMarker'     => '/* testNamespacedArrayKeyExists */',
				'expectedResult' => false,
			),
			'namespace_relative_array_key_exists' => array(
				'testMarker'     => '/* testNamespaceRelativeArrayKeyExists */',
				'expectedResult' => false,
			),
			'namespace_relative_key_exists' => array(
				'testMarker'     => '/* testNamespaceRelativeKeyExists */',
				'expectedResult' => false,
			),
			'partially_qualified_array_key_exists' => array(
				'testMarker'     => '/* testPartiallyQualifiedArrayKeyExists */',
				'expectedResult' => false,
			),
			'partially_qualified_key_exists' => array(
				'testMarker'     => '/* testPartiallyQualifiedKeyExists */',
				'expectedResult' => false,
			),
			'isset_single_param' => array(
				'testMarker'     => '/* testIssetSingleParam */',
				'expectedResult' => true,
			),
			'isset_first_of_two' => array(
				'testMarker'     => '/* testIssetFirstOfTwo */',
				'expectedResult' => true,
			),
			'isset_second_of_two' => array(
				'testMarker'     => '/* testIssetSecondOfTwo */',
				'expectedResult' => true,
			),
			'isset_array_access' => array(
				'testMarker'     => '/* testIssetArrayAccess */',
				'expectedResult' => true,
			),
			'empty_single_param' => array(
				'testMarker'     => '/* testEmptySingleParam */',
				'expectedResult' => true,
			),
			'empty_array_access' => array(
				'testMarker'     => '/* testEmptyArrayAccess */',
				'expectedResult' => true,
			),
			'array_key_exists_second_param' => array(
				'testMarker'     => '/* testArrayKeyExistsSecondParam */',
				'expectedResult' => true,
			),
			'array_key_exists_second_param_variable' => array(
				'testMarker'     => '/* testArrayKeyExistsSecondParamVariable */',
				'expectedResult' => true,
			),
			'array_key_exists_nested_array' => array(
				'testMarker'     => '/* testArrayKeyExistsNestedArray */',
				'expectedResult' => true,
			),
			'key_exists_second_param' => array(
				'testMarker'     => '/* testKeyExistsSecondParam */',
				'expectedResult' => true,
			),
			'key_exists_second_param_variable' => array(
				'testMarker'     => '/* testKeyExistsSecondParamVariable */',
				'expectedResult' => true,
			),
			'fully_qualified_array_key_exists' => array(
				'testMarker'     => '/* testFullyQualifiedArrayKeyExists */',
				'expectedResult' => true,
			),
			'fully_qualified_key_exists' => array(
				'testMarker'     => '/* testFullyQualifiedKeyExists */',
				'expectedResult' => true,
			),
			'array_key_exists_complex_nested_array' => array(
				'testMarker'     => '/* testArrayKeyExistsComplexNestedArray */',
				'expectedResult' => true,
			),
			'key_exists_complex_nested_array' => array(
				'testMarker'     => '/* testKeyExistsComplexNestedArray */',
				'expectedResult' => true,
			),
			'array_key_exists_simple_variable' => array(
				'testMarker'     => '/* testArrayKeyExistsSimpleVariable */',
				'expectedResult' => true,
			),
		);
	}
}
