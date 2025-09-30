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
 * Tests for the `ContextHelper::is_in_array_comparison()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ContextHelper::is_in_array_comparison()
 */
final class IsInArrayComparisonUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_in_array_comparison().
	 *
	 * @dataProvider dataIsInArrayComparison
	 *
	 * @param string     $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool       $expectedResult The expected return value.
	 * @param int|string $tokenType      Optional. The token type to search for.
	 *
	 * @return void
	 */
	public function testIsInArrayComparison( $testMarker, $expectedResult, $tokenType = \T_VARIABLE ) {
		$stackPtr = $this->getTargetToken( $testMarker, $tokenType );
		$result   = ContextHelper::is_in_array_comparison( self::$phpcsFile, $stackPtr );

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|int>>
	 * @see testIsInArrayComparison()
	 */
	public static function dataIsInArrayComparison() {
		return array(
			'other_function_call' => array(
				'testMarker'     => '/* testOtherFunctionCall */',
				'expectedResult' => false,
			),
			'variable_assignment' => array(
				'testMarker'     => '/* testVariableAssignment */',
				'expectedResult' => false,
			),
			'different_function_call' => array(
				'testMarker'     => '/* testDifferentFunctionCall */',
				'expectedResult' => false,
			),
			'partially_qualified_in_array' => array(
				'testMarker'     => '/* testPartiallyQualifiedInArray */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_array_search' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedArraySearch */',
				'expectedResult' => false,
			),
			'object_method_in_array' => array(
				'testMarker'     => '/* testObjectMethodInArray */',
				'expectedResult' => false,
			),
			'static_method_in_array' => array(
				'testMarker'     => '/* testStaticMethodInArray */',
				'expectedResult' => false,
			),
			'array_keys_first_param_only' => array(
				'testMarker'     => '/* testArrayKeysFirstParamOnly */',
				'expectedResult' => false,
			),
			'array_keys_wrong_named_param' => array(
				'testMarker'     => '/* testArrayKeysWrongNamedParam */',
				'expectedResult' => false,
			),
			'namespace_relative_in_array' => array(
				'testMarker'     => '/* testNamespaceRelativeInArray */',
				'expectedResult' => false,
			),
			'in_array_basic' => array(
				'testMarker'     => '/* testInArrayBasic */',
				'expectedResult' => true,
			),
			'in_array_with_strict' => array(
				'testMarker'     => '/* testInArrayWithStrict */',
				'expectedResult' => true,
			),
			'array_search_basic' => array(
				'testMarker'     => '/* testArraySearchBasic */',
				'expectedResult' => true,
			),
			'array_search_with_strict' => array(
				'testMarker'     => '/* testArraySearchWithStrict */',
				'expectedResult' => true,
			),
			'array_keys_with_filter_value' => array(
				'testMarker'     => '/* testArrayKeysWithFilterValue */',
				'expectedResult' => true,
			),
			'array_keys_with_filter_value_and_strict' => array(
				'testMarker'     => '/* testArrayKeysWithFilterValueAndStrict */',
				'expectedResult' => true,
			),
			'array_keys_named_params' => array(
				'testMarker'     => '/* testArrayKeysNamedParams */',
				'expectedResult' => true,
			),
			'array_keys_named_params_with_strict' => array(
				'testMarker'     => '/* testArrayKeysNamedParamsWithStrict */',
				'expectedResult' => true,
			),
			'in_array_uppercase' => array(
				'testMarker'     => '/* testInArrayUppercase */',
				'expectedResult' => true,
			),
			'array_search_mixed_case' => array(
				'testMarker'     => '/* testArraySearchMixedCase */',
				'expectedResult' => true,
			),
			'array_keys_uppercase' => array(
				'testMarker'     => '/* testArrayKeysUppercase */',
				'expectedResult' => true,
			),
			'in_array_fully_qualified' => array(
				'testMarker'     => '/* testInArrayFullyQualified */',
				'expectedResult' => true,
			),
			'array_search_fully_qualified' => array(
				'testMarker'     => '/* testArraySearchFullyQualified */',
				'expectedResult' => true,
			),
			'array_keys_fully_qualified' => array(
				'testMarker'     => '/* testArrayKeysFullyQualified */',
				'expectedResult' => true,
			),
			'in_array_object_property' => array(
				'testMarker'     => '/* testInArrayObjectProperty */',
				'expectedResult' => true,
			),
			'array_search_array_access' => array(
				'testMarker'     => '/* testArraySearchArrayAccess */',
				'expectedResult' => true,
			),
			'array_keys_function_call' => array(
				'testMarker'     => '/* testArrayKeysFunctionCall */',
				'expectedResult' => true,
				'tokenType'      => \T_STRING,
			),
			'in_array_first_param' => array(
				'testMarker'     => '/* testInArrayFirstParam */',
				'expectedResult' => true,
			),
			'in_array_second_param' => array(
				'testMarker'     => '/* testInArraySecondParam */',
				'expectedResult' => true,
			),
			'array_keys_nested_array_access' => array(
				'testMarker'     => '/* testArrayKeysNestedArrayAccess */',
				'expectedResult' => true,
			),
		);
	}
}
