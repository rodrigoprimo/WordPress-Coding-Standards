<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ContextHelper;

use PHPCSUtils\BackCompat\Helper;
use PHPCSUtils\Tokens\Collections;
use WordPressCS\WordPress\Helpers\ContextHelper;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the `ContextHelper::is_token_namespaced()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ContextHelper::is_token_namespaced()
 */
final class IsTokenNamespacedUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_token_namespaced() returns false if the token does not exist.
	 *
	 * @return void
	 */
	public function testIsTokenNamespacedReturnFalseIfTokenDoesntExist() {
		$this->assertFalse( ContextHelper::is_token_namespaced( self::$phpcsFile, -1 ) );
	}

	/**
	 * Test is_token_namespaced().
	 *
	 * @dataProvider dataIsTokenNamespaced
	 *
	 * @param string $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool   $expectedResult The expected return value.
	 * @param string $tokenContent   The token content to use for the target token.
	 *
	 * @return void
	 */
	public function testIsTokenNamespaced( $testMarker, $expectedResult, $tokenContent ) {
		$stackPtr = $this->getTargetToken( $testMarker, Collections::nameTokens(), $tokenContent );
		$result   = ContextHelper::is_token_namespaced( self::$phpcsFile, $stackPtr );

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsTokenNamespaced()
	 */
	public static function dataIsTokenNamespaced() {
		$isPhpcs3 = version_compare( Helper::getVersion(), '3.99.99', '<=' );

		return array(
			'unqualified_function' => array(
				'testMarker'     => '/* testUnqualifiedFunction */',
				'expectedResult' => false,
				'tokenContent'   => 'my_function',
			),
			'fully_qualified_function' => array(
				'testMarker'     => '/* testFullyQualifiedFunction */',
				'expectedResult' => false,
				'tokenContent'   => ( $isPhpcs3 ? 'my_function' : '\my_function' ),
			),
			'unqualified_class' => array(
				'testMarker'     => '/* testUnqualifiedClass */',
				'expectedResult' => false,
				'tokenContent'   => 'MyClass',
			),
			'fully_qualified_class' => array(
				'testMarker'     => '/* testFullyQualifiedClass */',
				'expectedResult' => false,
				'tokenContent'   => ( $isPhpcs3 ? 'MyClass' : '\MyClass' ),
			),
			'unqualified_constant' => array(
				'testMarker'     => '/* testUnqualifiedConstant */',
				'expectedResult' => false,
				'tokenContent'   => 'MY_CONSTANT',
			),
			'fully_qualified_constant' => array(
				'testMarker'     => '/* testFullyQualifiedConstant */',
				'expectedResult' => false,
				'tokenContent'   => ( $isPhpcs3 ? 'MY_CONSTANT' : '\MY_CONSTANT' ),
			),
			'partially_qualified_function' => array(
				'testMarker'     => '/* testPartiallyQualifiedFunction */',
				'expectedResult' => true,
				'tokenContent'   => ( $isPhpcs3 ? 'my_function' : 'MyNamespace\my_function' ),
			),
			'fully_qualified_namespaced_function' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedFunction */',
				'expectedResult' => true,
				'tokenContent'   => ( $isPhpcs3 ? 'my_function' : '\MyNamespace\my_function' ),
			),
			'namespace_relative_function' => array(
				'testMarker'     => '/* testNamespaceRelativeFunction */',
				'expectedResult' => true,
				'tokenContent'   => ( $isPhpcs3 ? 'my_function' : 'namespace\my_function' ),
			),
			'partially_qualified_class' => array(
				'testMarker'     => '/* testPartiallyQualifiedClass */',
				'expectedResult' => true,
				'tokenContent'   => ( $isPhpcs3 ? 'MyClass' : 'MyNamespace\MyClass' ),
			),
			'partially_qualified_constant' => array(
				'testMarker'     => '/* testPartiallyQualifiedConstant */',
				'expectedResult' => true,
				'tokenContent'   => ( $isPhpcs3 ? 'MY_CONSTANT' : 'MyNamespace\MY_CONSTANT' ),
			),
		);
	}
}
