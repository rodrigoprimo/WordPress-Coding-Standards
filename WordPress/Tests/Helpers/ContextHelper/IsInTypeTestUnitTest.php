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
 * Tests for the `ContextHelper::is_in_type_test()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ContextHelper::is_in_type_test()
 */
final class IsInTypeTestUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_in_type_test().
	 *
	 * @dataProvider dataIsInTypeTest
	 *
	 * @param string     $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool       $expectedResult The expected return value.
	 * @param int|string $tokenType      Optional. The token type to search for.
	 *
	 * @return void
	 */
	public function testIsInTypeTest( $testMarker, $expectedResult, $tokenType = \T_VARIABLE ) {
		$stackPtr = $this->getTargetToken( $testMarker, $tokenType );
		$result   = ContextHelper::is_in_type_test( self::$phpcsFile, $stackPtr );

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|int>>
	 * @see testIsInTypeTest()
	 */
	public static function dataIsInTypeTest() {
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
			'partially_qualified_is_numeric' => array(
				'testMarker'     => '/* testPartiallyQualifiedIsNumeric */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_is_array' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedIsArray */',
				'expectedResult' => false,
			),
			'object_method_is_string' => array(
				'testMarker'     => '/* testObjectMethodIsString */',
				'expectedResult' => false,
			),
			'static_method_is_int' => array(
				'testMarker'     => '/* testStaticMethodIsInt */',
				'expectedResult' => false,
			),
			'non_type_test_function' => array(
				'testMarker'     => '/* testNonTypeTestFunction */',
				'expectedResult' => false,
			),
			'namespace_relative_is_bool' => array(
				'testMarker'     => '/* testNamespaceRelativeIsBool */',
				'expectedResult' => false,
			),
			'custom_function_similar_name' => array(
				'testMarker'     => '/* testCustomFunctionSimilarName */',
				'expectedResult' => false,
			),
			'is_array' => array(
				'testMarker'     => '/* testIsArray */',
				'expectedResult' => true,
			),
			'is_bool' => array(
				'testMarker'     => '/* testIsBool */',
				'expectedResult' => true,
			),
			'is_callable' => array(
				'testMarker'     => '/* testIsCallable */',
				'expectedResult' => true,
			),
			'is_countable' => array(
				'testMarker'     => '/* testIsCountable */',
				'expectedResult' => true,
			),
			'is_double' => array(
				'testMarker'     => '/* testIsDouble */',
				'expectedResult' => true,
			),
			'is_float' => array(
				'testMarker'     => '/* testIsFloat */',
				'expectedResult' => true,
			),
			'is_int' => array(
				'testMarker'     => '/* testIsInt */',
				'expectedResult' => true,
			),
			'is_integer' => array(
				'testMarker'     => '/* testIsInteger */',
				'expectedResult' => true,
			),
			'is_iterable' => array(
				'testMarker'     => '/* testIsIterable */',
				'expectedResult' => true,
			),
			'is_long' => array(
				'testMarker'     => '/* testIsLong */',
				'expectedResult' => true,
			),
			'is_null' => array(
				'testMarker'     => '/* testIsNull */',
				'expectedResult' => true,
			),
			'is_numeric' => array(
				'testMarker'     => '/* testIsNumeric */',
				'expectedResult' => true,
			),
			'is_object' => array(
				'testMarker'     => '/* testIsObject */',
				'expectedResult' => true,
			),
			'is_real' => array(
				'testMarker'     => '/* testIsReal */',
				'expectedResult' => true,
			),
			'is_resource' => array(
				'testMarker'     => '/* testIsResource */',
				'expectedResult' => true,
			),
			'is_scalar' => array(
				'testMarker'     => '/* testIsScalar */',
				'expectedResult' => true,
			),
			'is_string' => array(
				'testMarker'     => '/* testIsString */',
				'expectedResult' => true,
			),
			'is_array_uppercase' => array(
				'testMarker'     => '/* testIsArrayUppercase */',
				'expectedResult' => true,
			),
			'is_bool_mixed_case' => array(
				'testMarker'     => '/* testIsBoolMixedCase */',
				'expectedResult' => true,
			),
			'is_numeric_uppercase' => array(
				'testMarker'     => '/* testIsNumericUppercase */',
				'expectedResult' => true,
			),
			'is_array_fully_qualified' => array(
				'testMarker'     => '/* testIsArrayFullyQualified */',
				'expectedResult' => true,
			),
			'is_string_fully_qualified' => array(
				'testMarker'     => '/* testIsStringFullyQualified */',
				'expectedResult' => true,
			),
			'is_numeric_fully_qualified' => array(
				'testMarker'     => '/* testIsNumericFullyQualified */',
				'expectedResult' => true,
			),
			'is_array_object_property' => array(
				'testMarker'     => '/* testIsArrayObjectProperty */',
				'expectedResult' => true,
			),
			'is_string_array_access' => array(
				'testMarker'     => '/* testIsStringArrayAccess */',
				'expectedResult' => true,
			),
			'is_numeric_function_call' => array(
				'testMarker'     => '/* testIsNumericFunctionCall */',
				'expectedResult' => true,
				'tokenType'      => \T_STRING,
			),
			'is_callable_with_second_param' => array(
				'testMarker'     => '/* testIsCallableWithSecondParam */',
				'expectedResult' => true,
			),
			'is_array_nested_array_access' => array(
				'testMarker'     => '/* testIsArrayNestedArrayAccess */',
				'expectedResult' => true,
			),
			'is_object_object_property' => array(
				'testMarker'     => '/* testIsObjectObjectProperty */',
				'expectedResult' => true,
			),
		);
	}
}
