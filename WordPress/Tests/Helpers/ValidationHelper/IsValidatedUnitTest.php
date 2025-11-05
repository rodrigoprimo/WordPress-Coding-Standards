<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ValidationHelper;

use WordPressCS\WordPress\Helpers\ValidationHelper;
use WordPressCS\WordPress\Helpers\VariableHelper;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the `ValidationHelper::is_validated()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ValidationHelper::is_validated()
 */
final class IsValidatedUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_validated().
	 *
	 * @dataProvider dataIsValidated
	 *
	 * @param string $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsValidated( $testMarker, $expectedResult ) {
		$stackPtr   = $this->getTargetToken( $testMarker, \T_VARIABLE );
		$array_keys = VariableHelper::get_array_access_keys( self::$phpcsFile, $stackPtr );
		$result     = ValidationHelper::is_validated( self::$phpcsFile, $stackPtr, $array_keys );

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsValidated()
	 */
	public static function dataIsValidated() {
		return array(
			'not_validated_echo' => array(
				'testMarker'     => '/* testNotValidatedEcho */',
				'expectedResult' => false,
			),
			'not_validated_assignment' => array(
				'testMarker'     => '/* testNotValidatedAssignment */',
				'expectedResult' => false,
			),
			'namespaced_array_key_exists' => array(
				'testMarker'     => '/* testNamespacedArrayKeyExists */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_array_key_exists' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedArrayKeyExists */',
				'expectedResult' => false,
			),
			'namespace_relative_array_key_exists' => array(
				'testMarker'     => '/* testNamespaceRelativeArrayKeyExists */',
				'expectedResult' => false,
			),
			'method_call' => array(
				'testMarker'     => '/* testMethodCall */',
				'expectedResult' => false,
			),
			'static_method_call' => array(
				'testMarker'     => '/* testStaticMethodCall */',
				'expectedResult' => false,
			),
			'namespaced_key_exists' => array(
				'testMarker'     => '/* testNamespacedKeyExists */',
				'expectedResult' => false,
			),
			'validated_with_isset' => array(
				'testMarker'     => '/* testValidatedWithIsset */',
				'expectedResult' => true,
			),
			'validated_with_empty' => array(
				'testMarker'     => '/* testValidatedWithEmpty */',
				'expectedResult' => true,
			),
			'validated_with_array_key_exists' => array(
				'testMarker'     => '/* testValidatedWithArrayKeyExists */',
				'expectedResult' => true,
			),
			'fully_qualified_array_key_exists' => array(
				'testMarker'     => '/* testFullyQualifiedArrayKeyExists */',
				'expectedResult' => true,
			),
			'validated_with_key_exists' => array(
				'testMarker'     => '/* testValidatedWithKeyExists */',
				'expectedResult' => true,
			),
			'fully_qualified_key_exists' => array(
				'testMarker'     => '/* testFullyQualifiedKeyExists */',
				'expectedResult' => true,
			),
			'validated_with_null_coalesce' => array(
				'testMarker'     => '/* testValidatedWithNullCoalesce */',
				'expectedResult' => true,
			),
			'multi_level_isset' => array(
				'testMarker'     => '/* testMultiLevelIsset */',
				'expectedResult' => true,
			),
			'multi_level_array_key_exists' => array(
				'testMarker'     => '/* testMultiLevelArrayKeyExists */',
				'expectedResult' => true,
			),
		);
	}
}
