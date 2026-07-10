<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ContextHelper;

use PHPCSUtils\TestUtils\UtilityMethodTestCase;
use WordPressCS\WordPress\Helpers\ContextHelper;

/**
 * Tests for the `ContextHelper::is_global_function_call()` utility method.
 *
 * @since 3.4.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ContextHelper::is_global_function_call
 */
final class IsGlobalFunctionCallUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_global_function_call() returns false if the token does not exist.
	 *
	 * @return void
	 */
	public function testIsGlobalFunctionCallReturnsFalseIfTokenDoesNotExist() {
		$this->assertFalse( ContextHelper::is_global_function_call( self::$phpcsFile, -1, 'valid_function' ) );
	}

	/**
	 * Test is_global_function_call().
	 *
	 * @dataProvider dataIsGlobalFunctionCall
	 *
	 * @param string     $marker         The comment which prefaces the target token in the test file.
	 * @param int|string $tokenType      The token type to search for.
	 * @param string     $tokenContent   The token content to target.
	 * @param string     $functionName   The function name to pass to is_global_function_call().
	 * @param bool       $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsGlobalFunctionCall( $marker, $tokenType, $tokenContent, $functionName, $expectedResult ) {
		$stackPtr = $this->getTargetToken( $marker, $tokenType, $tokenContent );
		$result   = ContextHelper::is_global_function_call( self::$phpcsFile, $stackPtr, $functionName );

		$this->assertSame( $expectedResult, $result, "Failed for: $marker" );
	}

	/**
	 * Data provider.
	 *
	 * @see testIsGlobalFunctionCall()
	 *
	 * @return array<string, array<string, bool|int|string>>
	 */
	public static function dataIsGlobalFunctionCall() {
		return array(
			// Cases that should return true.
			'lowercase_name' => array(
				'marker'         => '/* testLowercaseName */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => true,
			),
			'uppercase_name' => array(
				'marker'         => '/* testUppercaseName */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'VALID_FUNCTION',
				'functionName'   => 'valid_function',
				'expectedResult' => true,
			),
			'fully_qualified_global' => array(
				'marker'         => '/* testFullyQualifiedGlobal */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => true,
			),

			// Cases that should return false: wrong function name.
			'different_function' => array(
				'marker'         => '/* testDifferentFunction */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'other_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),

			// Cases that should return false: not followed by parentheses.
			'not_a_function_call' => array(
				'marker'         => '/* testNotAFunctionCall */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'VALID_FUNCTION',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),

			// Cases that should return false: method or namespaced calls.
			'object_method' => array(
				'marker'         => '/* testObjectMethod */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
			'nullsafe_object_method' => array(
				'marker'         => '/* testNullsafeObjectMethod */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
			'static_method' => array(
				'marker'         => '/* testStaticMethod */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
			'namespaced_function' => array(
				'marker'         => '/* testNamespacedFunction */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_function' => array(
				'marker'         => '/* testFullyQualifiedNamespacedFunction */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
			'namespace_relative_function' => array(
				'marker'         => '/* testNamespaceRelativeFunction */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
			'namespace_relative_sub_function' => array(
				'marker'         => '/* testNamespaceRelativeSubFunction */',
				'tokenType'      => \T_STRING,
				'tokenContent'   => 'valid_function',
				'functionName'   => 'valid_function',
				'expectedResult' => false,
			),
		);
	}
}
